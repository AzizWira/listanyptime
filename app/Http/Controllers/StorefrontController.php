<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\StoreSetting;
use Illuminate\View\View;
class StorefrontController extends Controller {
    public function index(): View {
        $categories=Category::query()->where('is_active',true)->orderBy('sort_order')->get();
        $products=Product::query()->where('is_active',true)
            ->with(['categories'=>fn($q)=>$q->where('is_active',true),'options.values','variants.values.option'])
            ->orderBy('sort_order')->get();
        $payload=$products->map(function(Product $product){
            return [
                'id'=>$product->id,'name'=>$product->name,'slug'=>$product->slug,'description'=>$product->description ?? '',
                'image'=>$product->image_path ? '/storage/'.$product->image_path : null,
                'badge'=>$product->badge,'keywords'=>$product->keywords ?? '','quantityMode'=>$product->quantity_mode,
                'categories'=>$product->categories->map(fn($c)=>['id'=>$c->id,'name'=>$c->name,'slug'=>$c->slug])->values(),
                'options'=>$product->options->map(fn($o)=>['id'=>$o->id,'name'=>$o->name,'values'=>$o->values->map(fn($v)=>['id'=>$v->id,'label'=>$v->value])->values()])->values(),
                'variants'=>$product->variants->map(fn($v)=>[
                    'id'=>$v->id,'regularPrice'=>(int)$v->regular_price,'promoPrice'=>$v->promo_price ? (int)$v->promo_price : null,
                    'status'=>$v->availability_status,
                    'valueIds'=>$v->values->pluck('id')->values(),
                    'labels'=>$v->values->mapWithKeys(fn($value)=>[$value->option->name=>$value->value]),
                ])->values(),
            ];
        })->values();
        $settings=[
            'storeName'=>StoreSetting::valueOf('store_name','@anyptime list'),
            'logo'=>($logo=StoreSetting::valueOf('logo_path')) ? '/storage/'.$logo : null,
            'tagline'=>StoreSetting::valueOf('tagline','Premium apps, harga manis 🎀'),
            'heroText'=>StoreSetting::valueOf('hero_text','Cari paket premium favoritmu, pilih variannya, lalu lanjut order lewat WhatsApp.'),
            'whatsapp'=>StoreSetting::valueOf('whatsapp_number','628132628586'),
            'opening'=>StoreSetting::valueOf('whatsapp_opening','Halo kak, saya mau order:'),
            'closing'=>StoreSetting::valueOf('whatsapp_closing','Mohon dibantu proses ya kak, terima kasih.'),
            'singleTemplate'=>StoreSetting::valueOf('whatsapp_single_template',"{opening}\n\n{product}\n{variant_lines}\nQty: {quantity}\nHarga: {price_line}\nSubtotal: {subtotal}\n\n{closing}"),
            'cartTemplate'=>StoreSetting::valueOf('whatsapp_cart_template',"{opening}\n\n{items}\n\nTotal: {total}\n\n{closing}"),
        ];
        return view('storefront',compact('categories','products','payload','settings'));
    }
}
