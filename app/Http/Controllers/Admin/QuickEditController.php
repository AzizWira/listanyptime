<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class QuickEditController extends Controller {
    public function index(Request $request): View {
        $products=Product::with(['categories','variants.values.option'])->orderBy('sort_order')->get(); $categories=Category::orderBy('sort_order')->get();
        return view('admin.products.quick-edit',compact('products','categories'));
    }
    public function update(Request $request): RedirectResponse {
        $data=$request->validate(['variants'=>['sometimes','array'],'variants.*.regular_price'=>['required','integer','min:0'],'variants.*.promo_price'=>['nullable','integer','min:0'],'variants.*.availability_status'=>['required','in:ready,sold_out']]);
        foreach($data['variants'] ?? [] as $id=>$row){
            $variant=ProductVariant::findOrFail($id); $promo=$row['promo_price']!==null && $row['promo_price']!=='' ? (int)$row['promo_price'] : null;
            if($promo!==null && $promo>(int)$row['regular_price']) return back()->with('error','Harga promo tidak boleh lebih tinggi dari harga normal.')->withInput();
            $variant->update(['regular_price'=>(int)$row['regular_price'],'promo_price'=>$promo,'availability_status'=>$row['availability_status']]);
        }
        return back()->with('success','Harga dan status berhasil diperbarui.');
    }
}
