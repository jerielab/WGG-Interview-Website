<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'stock_quantity', 'category'];

    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity == 0) return 'Out of Stock';
        if ($this->stock_quantity <= 10) return 'Low Stock';
        return 'In Stock';
    }
}
