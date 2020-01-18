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
        $products = $sale->products;

        $payment = new Payment();
        $payment->setCurrency('BRL');
        $payment->setReference($sale->id);
        $payment->setNotificationUrl($this->pagseguro->notification_url);

        $payment->setSender()->setName($sale->client_name)->setEmail($sale->client_email);
        $payment->setItems($this->cartToArray($products));

        $shipping = $payment->setShipping();
        $shipping->getType()->setType(3);
        $shipping->getCost()->setCost($carrier_cost);
        $shipping->setAddressRequired()->withParameters(false);


        try {
            return $payment->register($this->PS_credentials());
        } catch (\Exception $e) {
            error_log($e->getTraceAsString());
            return false;
        }
    }

    /**
     * @param SaleProduct[] $products
     * @return array
     */
    private function cartToArray($products)
    {
        return array_map(function ($p) {
            return (object)[
                'id'=>$p->id,
                'description'=>$p->name,
                'amount'=>$p->price,
                'quantity'=>$p->amount,
                'weight'=>50 //TODO
            ];
        }, $products->toArray());
    }
}
