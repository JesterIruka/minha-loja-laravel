<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingToken extends Model
{
    protected $fillable = ['token'];

    public $timestamps = false;
}
