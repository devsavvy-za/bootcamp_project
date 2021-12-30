<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // set
    protected $table = 'product';
    protected $fillable = ['product_category_id', 'title', 'slug', 'status'];


    /**
     * Product category.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * Product prices.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product_prices()
    {
        return $this->hasMany(ProductPrice::class);
    }
}
