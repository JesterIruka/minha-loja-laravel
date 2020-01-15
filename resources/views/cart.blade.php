@extends('layouts.home')

@section('content')
    <h1>Carrinho de Compras</h1>
    <hr>
    @if (empty($cart))
        <div class="alert alert-warning">Seu carrinho está vazio!</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>Variação</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @php $total=0; @endphp
                @foreach($cart as $e)
                    @php
                        $var = $e[0];
                        $amount = $e[1];
                        $total+= $var->price*$amount;
                    @endphp
                    <tr>
                        <td>{{$var->product->name}}</td>
                        <td>{{$var->name}}</td>
                        <td>{{$amount}}</td>
                        <td class="text-nowrap">R$ {{number_format($var->price*$amount, 2, ',', '.')}}</td>
                        <td>
                            <form action="{{route('cart.remove')}}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{$var->id}}">
                                <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"></td>
                    <td>Total</td>
                    <td class="text-nowrap">R$ {{number_format($total, 2, ',', '.')}}</td>
                    <td>
                        <form action="{{route('cart.destroy')}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger text-nowrap">Abandonar Carrinho</button>
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <form action="{{route('cart.checkout')}}" method="post" id="checkout_form">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h1>Checkout</h1>
                </div>
                <div class="card-body">
                    <div class="form-group col-md-6">
                        <label>Nome completo:</label>
                        <input type="text" name="client_name"
                               class="form-control @error('client_name') is-invalid @enderror"
                               value="{{old('client_name')}}" required>
                        @error('client_name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>Endereço de E-Mail:</label>
                        <input type="email" name="client_email"
                               class="form-control @error('client_email') is-invalid @enderror"
                               value="{{old('client_email')}}" required>
                        @error('client_email')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>Celular:</label>
                        <input type="text" name="client_phone"
                               class="form-control @error('client_phone') is-invalid @enderror"
                               value="{{old('client_phone')}}" required>
                        @error('client_phone')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                        <small>O processo do seu pedido será informado por SMS</small>
                    </div>
                </div>
                <div class="card-footer">
                    <h1>Dados para Entrega</h1>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>CEP *</label>
                            <input id="cep" type="text" name="endereco[cep]"
                                   class="form-control @error('endereco.cep') is-invalid @enderror" required>
                            @error('endereco.cep')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-5">
                            <label>Logradouro:</label>
                            <input id="logradouro" type="text" name="endereco[logradouro]"
                                   value="{{old('endereco.logradouro')}}"
                                   class="form-control @error('endereco.logradouro') is-invalid @enderror" required readonly>
                            @error('endereco.logradouro')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label>Numero *</label>
                            <input id="numero" type="number" name="endereco[numero]" value="{{old('endereco.numero')}}"
                                   class="form-control @error('endereco.numero') is-invalid @enderror" required>
                            @error('endereco.numero')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Complemento:</label>
                            <input id="complemento" type="text" name="endereco[complemento]"
                                   value="{{old('endereco.complemento')}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Bairro:</label>
                            <input id="bairro" type="text" name="endereco[bairro]" value="{{old('endereco.bairro')}}"
                                   class="form-control @error('endereco.bairro') is-invalid @enderror" required readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Estado:</label>
                            <input id="estado" type="text" name="endereco[estado]" value="{{old('endereco.estado')}}"
                                   class="form-control @error('endereco.estado') is-invalid @enderror" required readonly>
                            @error('endereco.estado')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Cidade:</label>
                            <input id="cidade" type="text" name="endereco[cidade]" value="{{old('endereco.cidade')}}"
                                   class="form-control @error('endereco.cidade') is-invalid @enderror" required readonly>
                            @error('endereco.cidade')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <h1>Frete</h1>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Método de Envio *</label>
                            <select name="carrier"
                                    class="form-control @error('carrier') is-invalid @enderror" required>
                                <option value="" disabled selected>Selecione uma transportadora</option>
                            </select>
                            @error('carrier')
                            <div class="invalid-feedback">
                                Selecione uma transportadora válida!
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label>Valor do Frete</label>
                            <input id="frete_valor" class="form-control" type="text" disabled>
                        </div>
                    </div>
                    <hr>
                    <h1>Método de pagamento</h1>
                    <div class="row">
                        <input id="gateway" type="hidden" name="gateway">
                        @if (config('payments.mercadopago')['enabled'])
                            <div class="col-md-3">
                                <button type="button" onclick="checkout('mercadopago')" class="btn btn-primary">MercadoPago</button>
                            </div>
                        @endif
                        <!-- INSERIR OUTROS MÉTODOS DE PAGAMENTO -->
                    </div>
                    @error('gateway')
                    <div class="alert alert-danger">
                        Escolha um método de pagamento válido
                    </div>
                    @enderror
                </div>
            </div>
        </form>
    @endif
@endsection
@section('script')
    <script src="/assets/js/jquery.mask.min.js"></script>
    <script type="text/javascript">

        function checkout(gateway) {
            $('#gateway').val(gateway);
            $('#checkout_form').submit();
        }

        cep = $('#cep');
        phone = $('input[name=client_phone]');
        transportadora = $('select[name=carrier]');

        phone.mask('+55 (00) 00000-0000');
        cep.mask('00000-000');

        $('input[type=email]').change(function () {
            let email = $(this).val();
            let valid = (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(email));
            setValid($(this), valid);
        });
        phone.change(function () {
            let celular = $(this).val();
            setValid($(this), /\+55 \(\d{2}\) \d{5}-\d{4}/.test(celular));
        });

        cep.change(function (e) {
            let cep = $(this).val();
            if (cep.length < 9) {
                setValid($(this), false);
                return;
            }
            cep = cep.replace('-', '');
            $.get('https://viacep.com.br/ws/' + cep + '/json/').done((res) => {
                $('#logradouro').val(res.logradouro);
                if ((compl = $('#complemento')).val() === '')
                    compl.val(res.complemento);
                $('#estado').val(res.uf);
                $('#cidade').val(res.localidade);
                $('#bairro').val(res.bairro);
                setValid($(this), true);
                loadShippingMehods();
            }).fail((error) => {
                alert('Falha ao buscar seu endereço, verifique se o CEP foi informado corretamente.');
                setValid($(this), false);
            });
        });

        transportadora.change(function () {
            let selected = $(this).find('option:selected');
            let valor = Number(selected.data('price')).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            $('#frete_valor').val('R$ ' + valor);
        });

        function loadShippingMehods() {
            transportadora.find("option[value!='']").remove();
            $.get('/cart/shipping_methods').done((res) => {
                for (let method in res) {
                    let price = res[method];
                    transportadora.append('<option data-price="' + price + '">' + method + '</option>');
                }
            }).fail(() => {
                alert('Falha ao consultar os métodos de envio')
            });
        }

        function setValid(field, valid) {
            if (valid) {
                field.addClass('is-valid');
                field.removeClass('is-invalid');
            } else {
                field.removeClass('is-valid');
                field.addClass('is-invalid');
            }
        }
    </script>
@endsection
