<?php
namespace Database\Seeders;
use App\Models\Category;
use App\Models\Product;
use App\Models\StoreSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::updateOrCreate(['email'=>env('ADMIN_EMAIL','admin@example.com')],[
            'name'=>env('ADMIN_NAME','Owner'),
            'password'=>Hash::make(env('ADMIN_PASSWORD','ChangeMe123!')),
        ]);
        $categoryNames=['Design','Streaming','Music','Productivity','AI'];
        $categories=[];
        foreach($categoryNames as $i=>$name){ $categories[$name]=Category::updateOrCreate(['slug'=>Str::slug($name)],['name'=>$name,'is_active'=>true,'sort_order'=>$i+1]); }
        $settings=[
            'store_name'=>'@anyptime list','tagline'=>'Premium apps, harga manis 🎀','hero_text'=>'Cari paket premium favoritmu, pilih variannya, lalu lanjut order lewat WhatsApp.',
            'whatsapp_number'=>'628132628586','whatsapp_opening'=>'Halo kak, saya mau order:','whatsapp_closing'=>'Mohon dibantu proses ya kak, terima kasih.',
            'whatsapp_single_template'=>"{opening}\n\n{product}\n{variant_lines}\nQty: {quantity}\nHarga: {price_line}\nSubtotal: {subtotal}\n\n{closing}",
            'whatsapp_cart_template'=>"{opening}\n\n{items}\n\nTotal: {total}\n\n{closing}",
        ]; foreach($settings as $key=>$value) StoreSetting::put($key,$value);
        $this->makeProduct($categories,'Canva Premium',['Design'],'Best Seller','Bisa untuk kebutuhan desain harian. Pilih tipe akses dan durasi sesuai kebutuhan.','multiple','products/demo-canva.png',[
            'Tipe'=>['Member','Designer'],'Durasi'=>['1 Hari','1 Minggu','1 Bulan']
        ],[
            [['Member','1 Hari'],5000,null,'ready'],[['Member','1 Minggu'],10000,8500,'ready'],[['Member','1 Bulan'],20000,null,'ready'],[['Designer','1 Minggu'],15000,null,'ready'],[['Designer','1 Bulan'],25000,22000,'ready'],
        ],1);
        $this->makeProduct($categories,'VIU Premium',['Streaming'],'Promo','Streaming drama dan series favorit dengan pilihan sharing atau private.','multiple','products/demo-viu.png',[
            'Tipe'=>['Sharing','Private'],'Durasi'=>['1 Bulan','3 Bulan']
        ],[
            [['Sharing','1 Bulan'],15000,12000,'ready'],[['Sharing','3 Bulan'],39000,null,'ready'],[['Private','1 Bulan'],28000,null,'ready'],[['Private','3 Bulan'],75000,null,'sold_out'],
        ],2);
        $this->makeProduct($categories,'Zoom Pro',['Productivity'],'Ready','Cocok untuk meeting, kelas online, dan kebutuhan kerja.','single','products/demo-zoom.png',[
            'Durasi'=>['1 Bulan','3 Bulan']
        ],[
            [['1 Bulan'],30000,null,'ready'],[['3 Bulan'],82000,null,'ready'],
        ],3);
        $this->makeProduct($categories,'Spotify Premium',['Music'],'Favorite','Dengarkan musik tanpa iklan dengan beberapa tipe paket.','multiple','products/demo-spotify.png',[
            'Paket'=>['Individual','Family Slot'],'Durasi'=>['1 Bulan','3 Bulan']
        ],[
            [['Individual','1 Bulan'],24000,null,'ready'],[['Individual','3 Bulan'],65000,59000,'ready'],[['Family Slot','1 Bulan'],18000,null,'ready'],
        ],4);
        $this->makeProduct($categories,'AI Assistant Pro',['AI'],'New','Akses paket premium untuk kebutuhan belajar, ide, dan produktivitas.','single','products/demo-ai.png',[
            'Akses'=>['Sharing','Private'],'Durasi'=>['1 Bulan']
        ],[
            [['Sharing','1 Bulan'],45000,null,'ready'],[['Private','1 Bulan'],135000,125000,'ready'],
        ],5);
    }
    private function makeProduct(array $categories,string $name,array $categoryNames,?string $badge,string $description,string $qty,string $image,array $options,array $variants,int $sort): void {
        $product=Product::updateOrCreate(['slug'=>Str::slug($name)],[
            'name'=>$name,'description'=>$description,'image_path'=>$image,'badge'=>$badge,'keywords'=>mb_strtolower($name.' '.$description),'quantity_mode'=>$qty,'is_active'=>true,'sort_order'=>$sort,
        ]);
        $product->categories()->sync(collect($categoryNames)->map(fn($n)=>$categories[$n]->id)->all());
        $product->options()->delete(); $product->variants()->delete();
        $valueMap=[];
        foreach($options as $optionIndex=>$values){
            $option=$product->options()->create(['name'=>$optionIndex,'sort_order'=>count($valueMap)+1]);
            foreach($values as $i=>$label){ $value=$option->values()->create(['value'=>$label,'sort_order'=>$i+1]); $valueMap[$label]=$value->id; }
        }
        foreach($variants as $i=>$row){ [$labels,$normal,$promo,$status]=$row; $variant=$product->variants()->create(['regular_price'=>$normal,'promo_price'=>$promo,'availability_status'=>$status,'sort_order'=>$i+1]); $variant->values()->sync(array_map(fn($label)=>$valueMap[$label],$labels)); }
    }
}
