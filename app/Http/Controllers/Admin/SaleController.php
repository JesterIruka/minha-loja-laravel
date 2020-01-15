<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Sale;
use App\Traits\TotalVoiceTrait;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    use TotalVoiceTrait;

    public function index()
    {
        $sales = Sale::paginate(10);
        return view('admin.sales.index', compact('sales'));
    }

    public function destroy($sale)
    {
        Sale::destroy($sale);
        flash('Venda removida com sucesso!')->success();
        return view('admin.sales.index');
    }

    public function despatch(Request $request)
    {
        $sale = Sale::find($request->get('id'));

        $sale->shipping_code = $request->get('shipping_code');
        $sale->status = Sale::DESPACHADO;
        $sale->save();

        $mensagem = str_replace('%s', $sale->shipping_code, config('store.messages')['sms_rastreio']);
        $sms = $this->enviarSMS($sale->client_phone, $mensagem);
        if ($sms === true) flash('Rastreamento enviado com sucesso!')->success();
        else flash('Falha ao enviar SMS: '.$sms)->error();

        return redirect($request->get('callback'));
    }
}
