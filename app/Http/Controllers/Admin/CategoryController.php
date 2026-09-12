<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
class CategoryController extends Controller {
    public function index(): View { $categories=Category::withCount('products')->orderBy('sort_order')->get(); return view('admin.categories.index',compact('categories')); }
    public function store(Request $request): RedirectResponse {
        $data=$request->validate(['name'=>['required','string','max:80'],'is_active'=>['nullable','boolean']]);
        Category::create(['name'=>$data['name'],'slug'=>$this->uniqueSlug($data['name']),'is_active'=>$request->boolean('is_active',true),'sort_order'=>(Category::max('sort_order')??0)+1]);
        return back()->with('success','Kategori berhasil ditambahkan.');
    }
    public function update(Request $request, Category $category): RedirectResponse {
        $data=$request->validate(['name'=>['required','string','max:80'],'is_active'=>['nullable','boolean']]);
        $category->update(['name'=>$data['name'],'slug'=>$this->uniqueSlug($data['name'],$category->id),'is_active'=>$request->boolean('is_active')]);
        return back()->with('success','Kategori berhasil diperbarui.');
    }
    public function destroy(Category $category): RedirectResponse {
        if($category->products()->exists()) return back()->with('error','Kategori masih dipakai produk. Pindahkan produknya dulu.');
        $category->delete(); return back()->with('success','Kategori dihapus.');
    }
    public function reorder(Request $request): JsonResponse {
        $ids=$request->validate(['order'=>['required','array'],'order.*'=>['integer','exists:categories,id']])['order'];
        foreach($ids as $index=>$id) Category::whereKey($id)->update(['sort_order'=>$index+1]);
        return response()->json(['ok'=>true]);
    }
    private function uniqueSlug(string $name, ?int $ignore=null): string {
        $base=Str::slug($name) ?: 'kategori'; $slug=$base; $i=2;
        while(Category::where('slug',$slug)->when($ignore,fn($q)=>$q->whereKeyNot($ignore))->exists()) $slug=$base.'-'.$i++;
        return $slug;
    }
}
