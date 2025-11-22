<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'farmer_id',
        'name',
        'description',
        'category',
        'price',
        'unit',
        'quantity_available',
        'image_path',
        'status',
        'is_organic',
        'harvest_date',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'quantity_available' => 'integer',
        'is_organic' => 'boolean',
        'harvest_date' => 'date',
    ];

    /**
     * Get the farmer that owns the product.
     */
    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('quantity_available', '>', 0);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get the product image URL or default.
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image_path
            ? asset('assets/images/products/' . $this->image_path)
            : asset('assets/images/default-product.png');
    }

    /**
     * Check if product is available for purchase.
     */
    public function isAvailable(): bool
    {
        return $this->status === 'active' && $this->quantity_available > 0;
    }

    /**
     * Get formatted price with currency.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rs. ' . number_format($this->price, 2);
    }
}