@extends('layouts.panel')

@section('content')
    <div class="table-responsive mt-2">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @if ($sales->count())
                @foreach($sales as $sale)
                    <div class="modal fade" id="details-{{$sale->id}}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1>Detalhes de #{{$sale->id}}</h1>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <ul class="list-group">
                                            <li class="list-group-item"><strong>ID:</strong> <span>{{$sale->id}}</span>
                                            </li>
                                            <li class="list-group-item"><strong>Gateway:</strong>
                                                <span>{{$sale->gateway}}</span></li>
                                            <li class="list-group-item"><strong>Transação:</strong>
                                                <span>{{empty($sale->transaction) ? 'Não realizada' : $sale->transaction}}</span></li>
                                            <li class="list-group-item"><strong>Total:</strong>
                                                <span>R$ {{number_format($sale->total, 2, ',', '.')}}</span></li>
                                            <li class="list-group-item"><strong>Status:</strong>
                                                @if ($sale->status == \App\Sale::PENDENTE)
                                                    <span class="btn btn-sm btn-secondary">Pendente</span>
                                                @elseif ($sale->status == \App\Sale::APROVADO)
                                                    <span class="btn btn-sm btn-success">Aprovado</span>
                                                @elseif ($sale->status == \App\Sale::DESPACHADO)
                                                    <span class="btn btn-sm btn-info">Despachado</span>
                                                @elseif ($sale->status == \App\Sale::ENTREGUE)
                                                    <span class="btn btn-sm btn-primary">Entregue</span>
                                                @elseif ($sale->status == \App\Sale::CANCELADO)
                                                    <span class="btn btn-sm btn-danger">Cancelado</span>
                                                @elseif ($sale->status == \App\Sale::DISPUTA)
                                                    <span class="btn btn-sm btn-danger">Disputa em Aberto</span>
                                                @elseif ($sale->status == \App\Sale::REEMBOLSADO)
                                                    <span class="btn btn-sm btn-danger">Reembolsado</span>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                    @if ($sale->products->count())
                                        <div>
                                            <div class="text-center">
                                                <h3>Pedidos</h3>
                                            </div>
                                            <ul class="list-group">
                                                @foreach ($sale->products as $product)
                                                    <li class="list-group-item"><strong>{{$product->amount}}x </strong>{{$product->name}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-center">
                                            <h3>Cliente</h3>
                                        </div>
                                        <ul class="list-group">
                                            <li class="list-group-item"><strong>Nome:</strong>
                                                <span>{{$sale->client_name}}</span></li>
                                            <li class="list-group-item"><strong>Email:</strong>
                                                <span>{{$sale->client_email}}</span></li>
                                            <li class="list-group-item"><strong>Celular:</strong>
                                                <span>{{$sale->client_phone}}</span></li>
                                            <li class="list-group-item"><strong>Endereço:</strong>
                                                <span>{{$sale->client_address}}</span></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <div class="text-center">
                                            <h3>Outros dados</h3>
                                        </div>
                                        <ul class="list-group">
                                            <li class="list-group-item"><strong>Rastreio:</strong>
                                                @if($sale->shipping_code)
                                                    <span>{{$sale->shipping_code}}</span>
                                                @else
                                                    <span>Este pedido não foi despachado</span>
                                                @endif
                                            </li>
                                            <li class="list-group-item"><strong>Última atualização:</strong>
                                                <span>{{$sale->updated_at->format('d/m/Y H:i:s')}}</span></li>
                                            <li class="list-group-item"><strong>Data do pedido:</strong>
                                                <span>{{$sale->created_at->format('d/m/Y H:i:s')}}</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger btn-sm" data-dismiss="modal">FECHAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <tr>
                        <td>{{$sale->id}}</td>
                        <td>{{$sale->client_name}}</td>
                        <td class="text-nowrap">R$ {{number_format($sale->total, 2, ',', '.')}}</td>
                        <td class="text-center">
                            @if ($sale->status == \App\Sale::PENDENTE)
                                <span class="btn btn-sm btn-secondary">Pendente</span>
                            @elseif ($sale->status == \App\Sale::APROVADO)
                                <span class="btn btn-sm btn-success">Aprovado</span>
                            @elseif ($sale->status == \App\Sale::DESPACHADO)
                                <span class="btn btn-sm btn-info">Despachado</span>
                            @elseif ($sale->status == \App\Sale::ENTREGUE)
                                <span class="btn btn-sm btn-primary">Entregue</span>
                            @elseif ($sale->status == \App\Sale::CANCELADO)
                                <span class="btn btn-sm btn-danger">Cancelado</span>
                            @elseif ($sale->status == \App\Sale::DISPUTA)
                                <span class="btn btn-sm btn-danger">Disputa em Aberto</span>
                            @elseif ($sale->status == \App\Sale::REEMBOLSADO)
                                <span class="btn btn-sm btn-danger">Reembolsado</span>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <div class="btn-group">
                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#details-{{$sale->id}}">DETALHES
                                </button>
                                @if ($sale->status == \App\Sale::APROVADO)
                                    <button class="btn btn-info btn-sm" onclick="openDispatch({{$sale->id}})">ENVIAR
                                        RASTREIO
                                    </button>
                                @endif
                                <form action="{{route('admin.sales.destroy', ['sale'=>$sale->id])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">EXCLUIR</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <td colspan="3">Nenhum produto encontrado!</td>
            @endif
            </tbody>
        </table>
    </div>
    <div>
        {{$sales->links()}}
    </div>
    <div class="modal rade" id="dispatch">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('admin.sales.dispatch')}}" method="post">
                    <div class="modal-header">
                        <h2>Despachar pedido</h2>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id">
                        <input type="hidden" name="callback" value="{{request()->fullUrl()}}">
                        <label>Código de Rastreio</label>
                        <input type="text" name="shipping_code" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">FECHAR</button>
                        <button type="submit" class="btn btn-sm btn-info">ENVIAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function openDispatch(id) {
            let modal = $('#dispatch');
            modal.find('input[name=id]').val(id);
            modal.find('input[name=shipping_code]').val('');
            modal.modal('show');
        }
    </script>
@endsection
