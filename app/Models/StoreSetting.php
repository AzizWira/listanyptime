<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class StoreSetting extends Model {
    protected $primaryKey='key'; public $incrementing=false; protected $keyType='string';
    protected $fillable=['key','value'];
    public static function valueOf(string $key, ?string $default=null): ?string { return static::query()->whereKey($key)->value('value') ?? $default; }
    public static function put(string $key, ?string $value): void { static::query()->updateOrCreate(['key'=>$key],['value'=>$value]); }
}
