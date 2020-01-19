<?php


namespace App\Traits;


use MercadoPago\Preference;
use MercadoPago\SDK;

trait MercadoPagoTrait
{

    private $mercadopago;

    public function MP_initialize()
    {
        $this->mercadopago = (object)config('payments.mercadopago');
        SDK::setClientId($this->mercadopago->CLIENT_ID);
        SDK::setClientSecret($this->mercadopago->CLIENT_SECRET);
    }

    public function MP_createPreference($sale, $carrier_cost)
    {
        $products = $sale->products;

        $preference = new Preference();

        $preference->items = $this->MP_cartToArray($products);
        $preference->payer = (object) ['name'=>$sale->client_name, 'email'=>$sale->client_email];
        $preference->notification_url = $this->mercadopago->notification_url;
        $preference->external_reference = $sale->id;
        $preference->shipments = (object)['mode'=>'not_specified', 'cost'=>$carrier_cost];
//        $preference->back_urls = [
//            "success" => "https://www.seu-site/success",
//            "failure" => "http://www.seu-site/failure",
//            "pending" => "http://www.seu-site/pending"
//        ];
//        $preference->auto_return = 'approved'; TODO

        try {
            $preference->save();
            return $preference->init_point;
        } catch (\Exception $e) {
            error_log($e->getTraceAsString());
            return false;
        }
    }

    private function MP_cartToArray($products)
    {
        return array_map(function ($p) {
            return (object)['id'=>$p['id'],'title'=>$p['name'],'quantity'=>$p['amount'],'unit_price'=>floatval($p['price']),'currency_id'=>'BRL'];
        }, $products->toArray());
    }
}
