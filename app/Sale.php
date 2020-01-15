<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    const PENDENTE = 'pending';
    const APROVADO = 'approved';
    const DESPACHADO = 'dispatched';
    const ENTREGUE = 'delivered';
    const CANCELADO = 'cancelled';
    const DISPUTA = 'dispute';
    const REEMBOLSADO = 'refunded';

    protected $fillable = ['gateway','transaction','total','status','client_name',
        'client_email','client_phone','client_address','carrier','shipping_code'];

    public function products()
    {
        return $this->hasMany(SaleProduct::class);
    }
}
