<?php


namespace App\Traits;


use App\ProductVariation;
use App\Sale;
use App\SaleProduct;
use MercadoPago\Preference;
use MercadoPago\SDK;
use PagSeguro\Configuration\Configure;
use PagSeguro\Domains\Account;
use PagSeguro\Domains\Requests\Payment;
use PagSeguro\Domains\ShippingCost;
use PagSeguro\Domains\ShippingType;
use PagSeguro\Library;

trait PagSeguroTrait
{

    private $pagseguro;

    public function __construct()
    {
        $this->pagseguro = (object)config('payments.pagseguro');
    }

    public function PS_initialize()
    {
        Library::initialize();
        Configure::setAccountCredentials($this->pagseguro->email, $this->pagseguro->token);
    }

    public function PS_credentials()
    {
        return Configure::getAccountCredentials();
    }

    public function PS_createPayment($sale, $carrier_cost)
    {
        $endereco = array_map(function ($el) {
            trim($el);
            }, explode(',', $sale->client_address));
        $products = $sale->products;

        $payment = new Payment();
        $payment->setCurrency('BRL');
        $payment->setReference($sale->id);
        $payment->setNotificationUrl($this->pagseguro->notification_url);

        $payment->setSender()->setName($sale->client_name)->setEmail($sale->client_email);

        foreach ($products as $p)
            $payment->addItems()->withParameters($p->id, $p->name, $p->amount, $p->price);

        $shipping = $payment->setShipping();
        $shipping->setType()->withParameters(3);
        $shipping->setCost()->withParameters($carrier_cost);

        try {
            return $payment->register($this->PS_credentials());
        } catch (\Exception $e) {
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            return false;
        }
    }

    /**
     * @param SaleProduct[] $products
     * @return array
     */
    private function PS_cartToArray($products)
    {
        return array_map(function ($p) {
            return (object)[
                'id'=>$p['id'],
                'description'=>$p['name'],
                'amount'=>$p['price'],
                'quantity'=>$p['amount'],
                'weight'=>50 //TODO
            ];
        }, $products->toArray());
    }
}
