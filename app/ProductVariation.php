<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{

    protected $fillable = ['product_id', 'name', 'price', 'stock'];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function fullName()
    {
        return $this->product->name.' - '.$this->name;
    }
}
