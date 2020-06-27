<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image'
    ];
    /**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);//('App\Product');// Product::class);
    }
}
