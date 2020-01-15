<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Product;
use App\ProductVariation;
use App\Sale;
use App\Traits\MercadoPagoTrait;
use Illuminate\Http\Request;

class CartController extends Controller
{

    use MercadoPagoTrait;

    public function index()
    {
        $cart = $this->convertCart();
        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $id = $request->get('id');
        $amount = $request->get('amount');
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) $cart[$id]+=$amount;
        else $cart[$id] = $amount;
        session()->put('cart', $cart);
        flash('Produto adicionado ao carrinho!')->success();
        return redirect($request->get('callback'));
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->get('id')]);
        session()->put('cart', $cart);
        flash('Produto removido do carrinho!')->success();
        return redirect()->route('cart.index');
    }

    public function destroy()
    {
        session()->forget('cart');
        flash('Seu carrinho de compras foi abandonado!')->success();
        return redirect()->route('cart.index');
    }

    public function shippingMethods()
    {
//        $onlyMethods = $request->get('onlyMethods', false);

        $cart = session()->get('cart', []);

        return [
            'Carta Registrada'=>8.25
        ];
    }

    public function checkout(CheckoutRequest $request)
    {
        $cart = $this->convertCart();

        if ($cart === false) {
            return redirect()->route('cart.index');
        }

        $data = $request->all();
        $carrier = $this->shippingMethods()[$carrierName = $data['carrier']];
        $end = (object) $data['endereco'];
        $data['client_address'] = $end->estado.', '.$end->cidade.', '.$end->cep.', '.$end->logradouro.', '.$end->numero.', compl: '.
            $end->complemento.', bairro: '.$end->bairro;
        unset($data['endereco']);
        $data['status'] = Sale::PENDENTE;
        $data['total'] = $this->getTotal($cart)+$carrier;

        $sale = Sale::create($data);
        foreach ($cart as $e) {
            $var = $e[0]; $amount = $e[1];
            $name = $var->product->name.' - '.$var->name;
            $price = $var->price;
            $sale->products()->create(compact('name', 'amount', 'price'));

            $var->update(['stock'=>$var->stock-$amount]);
        }

        if ($sale->gateway == 'mercadopago') {
            $this->MP_initialize();
            $res = $this->MP_criarPreferencia($sale, $carrierName, $carrier);
            if ($res) return redirect($res);
            else {
                flash('Ocorreu um erro durante a sua compra, por favor entre em contato.');
                return redirect()->route('cart.index');
            }
        }
    }

    private function getTotal($cart)
    {
        $total = 0;
        foreach ($cart as $e) $total+= $e[0]->price * $e[1];
        return $total;
    }

    //Retorna [[variacao, quantidade]...]
    private function convertCart($checkout=false)
    {
        $original = session()->get('cart', []);
        $variations = $this->findVariations(array_keys($original));
        $cart = [];
        foreach ($original as $id => $amount) {
            if (!isset($variations[$id])) {
                unset($original[$id]);
                if ($checkout) return false; else continue;
            } else if ($amount > ($var = $variations[$id])->stock) {
                if ($var->stock == 0) {
                    unset($original[$id]);
                    flash($var->fullName().' não está com estoque disponível no momento.')->error();
                } else {
                    $amount = $var->stock;
                    $original[$id] = $var->stock;
                    flash($var->fullName().' teve sua quantidade ajustada para o estoque atual ('.$var->stock.')')->warning();
                }
                if ($checkout) return false;
            }
            session()->put('cart', $original);
            $cart[]= [$var, $amount];
        }
        return $cart;
    }

    function findVariations($ids)
    {
        $response = [];
        $variations = ProductVariation::find($ids);
        foreach ($variations as $var) {
            if ($var != null) $response[$var->id] = $var;
        }
        return $response;
    }
}
