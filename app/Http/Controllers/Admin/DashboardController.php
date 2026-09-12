<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\View\View;
class DashboardController extends Controller {
    public function __invoke(): View {
        $stats=['products'=>Product::count(),'active'=>Product::where('is_active',true)->count(),'soldOut'=>ProductVariant::where('availability_status','sold_out')->count(),'categories'=>Category::count()];
        $recent=Product::latest('updated_at')->limit(5)->get();
        return view('admin.dashboard',compact('stats','recent'));
    }
}
