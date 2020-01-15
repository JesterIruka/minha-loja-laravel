<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{

    public $timestamps = false;
    protected $fillable = ['path'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
