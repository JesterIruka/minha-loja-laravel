<?php

namespace App\Http\Controllers\IPN;

use App\Http\Controllers\Controller;
use App\Sale;
use App\Traits\PagSeguroTrait;
use Illuminate\Http\Request;
use PagSeguro\Domains\Requests\DirectPreApproval\Status;
use PagSeguro\Services\Transactions\Notification;

class PagSeguro extends Controller
{

    use PagSeguroTrait;

    private $statuses = [
        '2'=>Sale::PENDENTE,
        '3'=>Sale::APROVADO,
        '5'=>Sale::DISPUTA,
        '6'=>Sale::REEMBOLSADO,
        '7'=>Sale::CANCELADO
    ];

    public function rest(Request $request)
    {
        $this->PS_initialize();

        $code = $request->get('notificationCode');
        if ($code != null) {
            try {
                $notification = Notification::check($this->PS_credentials());

                $status = $notification->getStatus();
                $sale = Sale::find($notification->getReference());

                if ($sale) {
                    $sale->transaction = $notification->getCode();
                    if (isset($this->statuses[$status]))
                        $sale->status = $this->statuses[$status];
                    $sale->save();
                }
            } catch (\Exception $e) {
                echo $e->getTraceAsString();
                return response($e->getTraceAsString(), 500);
            }
        }
        return response('OK', 200);
    }
}
