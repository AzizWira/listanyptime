<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class ProductVariant extends Model {
    protected $fillable=['product_id','sku','regular_price','promo_price','availability_status','sort_order'];
    protected $casts=['regular_price'=>'integer','promo_price'=>'integer'];
    public function product(): BelongsTo { return $this->belongsTo(Product::class); }
    public function values(): BelongsToMany { return $this->belongsToMany(ProductOptionValue::class,'product_variant_values'); }
    public function getEffectivePriceAttribute(): int { return (int)($this->promo_price ?? $this->regular_price); }
}
