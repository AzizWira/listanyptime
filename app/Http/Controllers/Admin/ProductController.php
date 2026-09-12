<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
class ProductController extends Controller {
    public function index(Request $request): View {
        $products=Product::with(['categories','variants'])->withCount('variants')->orderBy('sort_order')->get();
        return view('admin.products.index',compact('products'));
    }
    public function create(): View { $categories=Category::orderBy('sort_order')->get(); return view('admin.products.form',['product'=>new Product(),'categories'=>$categories]); }
    public function store(Request $request): RedirectResponse {
        $data=$this->validated($request); unset($data['remove_image']);
        $data['slug']=$this->uniqueSlug($data['name']); $data['sort_order']=(Product::max('sort_order')??0)+1; $data['is_active']=$request->boolean('is_active');
        if($request->hasFile('image')) $data['image_path']=$request->file('image')->store('products','public');
        $product=Product::create($data); $product->categories()->sync($request->input('categories',[]));
        return redirect()->route('admin.products.edit',$product)->with('success','Produk dibuat. Sekarang tambahkan opsi dan kombinasi harganya.');
    }
    public function edit(Product $product): View {
        $product->load(['categories','options.values','variants.values.option']); $categories=Category::orderBy('sort_order')->get();
        return view('admin.products.form',compact('product','categories'));
    }
    public function update(Request $request, Product $product): RedirectResponse {
        $data=$this->validated($request); unset($data['remove_image']); $data['slug']=$this->uniqueSlug($data['name'],$product->id); $data['is_active']=$request->boolean('is_active');
        if($request->boolean('remove_image') && !$request->hasFile('image')) {
            if($product->image_path) Storage::disk('public')->delete($product->image_path);
            $data['image_path']=null;
        }
        if($request->hasFile('image')) { if($product->image_path) Storage::disk('public')->delete($product->image_path); $data['image_path']=$request->file('image')->store('products','public'); }
        $product->update($data); $product->categories()->sync($request->input('categories',[]));
        return back()->with('success','Informasi produk disimpan.');
    }
    public function destroy(Product $product): RedirectResponse {
        if($product->image_path) Storage::disk('public')->delete($product->image_path); $product->delete();
        return redirect()->route('admin.products.index')->with('success','Produk dihapus.');
    }
    public function reorder(Request $request): JsonResponse {
        $ids=$request->validate(['order'=>['required','array'],'order.*'=>['integer','exists:products,id']])['order'];
        foreach($ids as $index=>$id) Product::whereKey($id)->update(['sort_order'=>$index+1]);
        return response()->json(['ok'=>true]);
    }
    private function validated(Request $request): array {
        return $request->validate([
            'name'=>['required','string','max:120'],'description'=>['nullable','string','max:2000'],'badge'=>['nullable','string','max:40'],'keywords'=>['nullable','string','max:500'],
            'quantity_mode'=>['required','in:multiple,single'],'image'=>['nullable','image','mimes:jpg,jpeg,png,webp','max:3072'],'categories'=>['required','array','min:1'],'categories.*'=>['integer','exists:categories,id']
        ]);
    }
    private function uniqueSlug(string $name, ?int $ignore=null): string {
        $base=Str::slug($name) ?: 'produk'; $slug=$base; $i=2;
        while(Product::where('slug',$slug)->when($ignore,fn($q)=>$q->where('id','!=',$ignore))->exists()) $slug=$base.'-'.$i++;
        return $slug;
    }
}
