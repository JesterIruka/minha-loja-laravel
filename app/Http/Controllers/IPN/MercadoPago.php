<?php

namespace App\Http\Controllers\IPN;

use App\Http\Controllers\Controller;
use App\Sale;
use App\Traits\MercadoPagoTrait;
use Illuminate\Http\Request;
use MercadoPago\Payment;

class MercadoPago extends Controller
{

    use MercadoPagoTrait;

    private $statuses = ['approved'=>Sale::APROVADO,'in_process'=>Sale::PENDENTE,'cancelled'=>Sale::CANCELADO,
        'in_mediation'=>Sale::DISPUTA, 'charged_back'=>Sale::REEMBOLSADO, 'refunded'=>Sale::REEMBOLSADO];

    public function rest(Request $request)
    {
        $this->MP_initialize();
        $id = $request->get('id');

        $payment = Payment::find_by_id($id);
        if (empty($payment)) return response('Payment not found', 404);
        $sale = Sale::findOrFail($payment->external_reference);
        $sale->transaction = $id;
        if (isset($this->statuses[$payment->status]))
            $sale->status = $this->statuses[$payment->status];

        $sale->save();
        return response('Payment updated', 200);
    }
}
