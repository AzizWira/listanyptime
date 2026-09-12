<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Product extends Model {
    protected $fillable=['name','slug','description','image_path','badge','keywords','quantity_mode','is_active','sort_order'];
    protected $casts=['is_active'=>'boolean'];
    public function categories(): BelongsToMany { return $this->belongsToMany(Category::class); }
    public function options(): HasMany { return $this->hasMany(ProductOption::class)->orderBy('sort_order'); }
    public function variants(): HasMany { return $this->hasMany(ProductVariant::class)->orderBy('sort_order'); }
    public function getRouteKeyName(): string { return 'slug'; }
    public function getDisplayPriceAttribute(): ?int {
        $variant=$this->variants->where('availability_status','ready')->sortBy(fn($v)=>$v->promo_price ?? $v->regular_price)->first();
        return $variant ? (int)($variant->promo_price ?? $variant->regular_price) : null;
    }
}
