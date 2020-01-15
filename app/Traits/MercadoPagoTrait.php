<?php


namespace App\Traits;


use MercadoPago\Preference;
use MercadoPago\SDK;

trait MercadoPagoTrait
{

    private $config;

    public function __construct()
    {
        $this->config = (object)config('payments.mercadopago');
    }

    public function MP_isEnabled()
    {
        return $this->config->enabled;
    }

    public function MP_initialize()
    {
        SDK::setClientId($this->config->CLIENT_ID);
        SDK::setClientSecret($this->config->CLIENT_SECRET);
    }

    /**
     * @param $sale
     * @return bool|string
     * @throws \Exception
     */
    public function MP_criarPreferencia($sale, $carrier, $carrier_cost)
    {
        $products = $sale->products;

        $preference = new Preference();

        $preference->items = $this->cartToArray($products);
        $preference->payer = (object) ['name'=>$sale->client_name, 'email'=>$sale->client_email];
        $preference->notification_url = $this->config->notification_url;
        $preference->external_reference = $sale->id;
        $preference->shipments = (object)['mode'=>'not_specified', 'cost'=>$carrier_cost];
        $preference->back_urls = [
            "success" => "https://www.seu-site/success",
            "failure" => "http://www.seu-site/failure",
            "pending" => "http://www.seu-site/pending"
        ];
        $preference->auto_return = 'approved';

        try {
            $preference->save();
            return $preference->init_point;
        } catch (\Exception $e) {
            error_log($e->getTraceAsString());
            return false;
        }
    }

    private function cartToArray($products)
    {
        return array_map(function ($p) {
            return (object)['id'=>$p['id'],'title'=>$p['name'],'quantity'=>$p['amount'],'unit_price'=>floatval($p['price']),'currency_id'=>'BRL'];
        }, $products->toArray());
    }
}
