<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('slug')->unique(); $table->boolean('is_active')->default(true); $table->unsignedInteger('sort_order')->default(0); $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('slug')->unique(); $table->text('description')->nullable(); $table->string('image_path')->nullable(); $table->string('badge')->nullable(); $table->text('keywords')->nullable(); $table->enum('quantity_mode',['multiple','single'])->default('multiple'); $table->boolean('is_active')->default(true); $table->unsignedInteger('sort_order')->default(0); $table->timestamps();
        });
        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained()->cascadeOnDelete(); $table->foreignId('product_id')->constrained()->cascadeOnDelete(); $table->primary(['category_id','product_id']);
        });
        Schema::create('product_options', function (Blueprint $table) {
            $table->id(); $table->foreignId('product_id')->constrained()->cascadeOnDelete(); $table->string('name'); $table->unsignedInteger('sort_order')->default(0); $table->timestamps();
        });
        Schema::create('product_option_values', function (Blueprint $table) {
            $table->id(); $table->foreignId('product_option_id')->constrained()->cascadeOnDelete(); $table->string('value'); $table->unsignedInteger('sort_order')->default(0); $table->timestamps();
        });
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id(); $table->foreignId('product_id')->constrained()->cascadeOnDelete(); $table->string('sku')->nullable(); $table->unsignedBigInteger('regular_price'); $table->unsignedBigInteger('promo_price')->nullable(); $table->enum('availability_status',['ready','sold_out'])->default('ready'); $table->unsignedInteger('sort_order')->default(0); $table->timestamps();
        });
        Schema::create('product_variant_values', function (Blueprint $table) {
            $table->foreignId('product_variant_id')->constrained()->cascadeOnDelete(); $table->foreignId('product_option_value_id')->constrained()->cascadeOnDelete(); $table->primary(['product_variant_id','product_option_value_id']);
        });
        Schema::create('store_settings', function (Blueprint $table) { $table->string('key')->primary(); $table->text('value')->nullable(); $table->timestamps(); });
    }
    public function down(): void {
        Schema::dropIfExists('store_settings'); Schema::dropIfExists('product_variant_values'); Schema::dropIfExists('product_variants'); Schema::dropIfExists('product_option_values'); Schema::dropIfExists('product_options'); Schema::dropIfExists('category_product'); Schema::dropIfExists('products'); Schema::dropIfExists('categories');
    }
};
