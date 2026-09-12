<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class VariantController extends Controller {
    public function storeOption(Request $request, Product $product): RedirectResponse {
        $data=$request->validate(['name'=>['required','string','max:60']]);
        if($product->options()->whereRaw('LOWER(name)=?', [mb_strtolower($data['name'])])->exists()) return back()->with('error','Nama opsi sudah ada pada produk ini.');
        $product->options()->create(['name'=>$data['name'],'sort_order'=>($product->options()->max('sort_order')??0)+1]);
        return back()->with('success','Opsi ditambahkan. Tambahkan pilihan nilainya.');
    }
    public function updateOption(Request $request, Product $product, ProductOption $option): RedirectResponse {
        abort_unless($option->product_id===$product->id,404);
        $data=$request->validate(['name'=>['required','string','max:60']]);
        if($product->options()->where('id','!=',$option->id)->whereRaw('LOWER(name)=?', [mb_strtolower($data['name'])])->exists()) return back()->with('error','Nama opsi tersebut sudah ada.');
        $option->update(['name'=>$data['name']]); return back()->with('success','Nama opsi diperbarui.');
    }
    public function destroyOption(Product $product, ProductOption $option): RedirectResponse {
        abort_unless($option->product_id===$product->id,404);
        $used=$option->values()->whereHas('variants')->exists(); if($used) return back()->with('error','Opsi masih dipakai varian. Hapus varian terkait dulu.');
        $option->delete(); return back()->with('success','Opsi dihapus.');
    }
    public function storeValue(Request $request, Product $product, ProductOption $option): RedirectResponse {
        abort_unless($option->product_id===$product->id,404);
        $data=$request->validate(['value'=>['required','string','max:80']]);
        if($option->values()->whereRaw('LOWER(value)=?', [mb_strtolower($data['value'])])->exists()) return back()->with('error','Pilihan tersebut sudah ada.');
        $option->values()->create(['value'=>$data['value'],'sort_order'=>($option->values()->max('sort_order')??0)+1]);
        return back()->with('success','Pilihan ditambahkan.');
    }
    public function updateValue(Request $request, Product $product, ProductOption $option, ProductOptionValue $value): RedirectResponse {
        abort_unless($option->product_id===$product->id && $value->product_option_id===$option->id,404);
        $data=$request->validate(['value'=>['required','string','max:80']]);
        if($option->values()->where('id','!=',$value->id)->whereRaw('LOWER(value)=?', [mb_strtolower($data['value'])])->exists()) return back()->with('error','Pilihan tersebut sudah ada.');
        $value->update(['value'=>$data['value']]); return back()->with('success','Nama pilihan diperbarui.');
    }
    public function destroyValue(Product $product, ProductOption $option, ProductOptionValue $value): RedirectResponse {
        abort_unless($option->product_id===$product->id && $value->product_option_id===$option->id,404);
        if($value->variants()->exists()) return back()->with('error','Pilihan masih dipakai varian. Hapus varian terkait dulu.');
        $value->delete(); return back()->with('success','Pilihan dihapus.');
    }
    public function storeVariant(Request $request, Product $product): RedirectResponse {
        $product->load('options.values','variants.values'); $optionCount=$product->options->count();
        $rules=['regular_price'=>['required','integer','min:0'],'promo_price'=>['nullable','integer','min:0'],'availability_status'=>['required','in:ready,sold_out']];
        if($optionCount>0) { $rules['values']=['required','array','size:'.$optionCount]; $rules['values.*']=['required','integer','exists:product_option_values,id']; }
        $data=$request->validate($rules); $valueIds=array_values(array_map('intval',$data['values']??[])); sort($valueIds);
        if($optionCount>0){
            $values=ProductOptionValue::with('option')->whereIn('id',$valueIds)->get();
            if($values->count()!==$optionCount || $values->pluck('option.product_id')->contains(fn($id)=>$id!==$product->id) || $values->pluck('product_option_id')->unique()->count()!==$optionCount) return back()->with('error','Kombinasi pilihan tidak valid.');
        }
        foreach($product->variants as $existing){ $ids=$existing->values->pluck('id')->map(fn($id)=>(int)$id)->sort()->values()->all(); if($ids===$valueIds) return back()->with('error','Kombinasi varian tersebut sudah ada.'); }
        if(!empty($data['promo_price']) && $data['promo_price']>$data['regular_price']) return back()->with('error','Harga promo sebaiknya tidak lebih tinggi dari harga normal.');
        $variant=$product->variants()->create(['regular_price'=>$data['regular_price'],'promo_price'=>$data['promo_price']?:null,'availability_status'=>$data['availability_status'],'sort_order'=>($product->variants()->max('sort_order')??0)+1]);
        $variant->values()->sync($valueIds);
        return back()->with('success','Kombinasi harga ditambahkan.');
    }
    public function destroyVariant(Product $product, ProductVariant $variant): RedirectResponse {
        abort_unless($variant->product_id===$product->id,404); $variant->delete(); return back()->with('success','Varian dihapus.');
    }
}
