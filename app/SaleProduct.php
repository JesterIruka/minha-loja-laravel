<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    public $timestamps = false;

    protected $fillable = ['name','price','amount'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
