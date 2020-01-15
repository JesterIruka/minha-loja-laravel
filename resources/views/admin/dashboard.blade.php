@extends('layouts.panel')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary h-100">
                <div class="card-title text-center h2">Pedidos do Dia</div>
                <div class="card-body text-center">
                    <span class="h1">{{$orders}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success h-100">
                <div class="card-title text-center h2">Faturamento do Mês</div>
                <div class="card-body text-center">
                    <span class="h1">R$ {{number_format($total, 2, ',', '.')}}</span>
                    <div>
                        Com {{$month_orders}} Pedidos
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info h-100">
                <div class="card-title text-center h2">Pedidos para Despachar</div>
                <div class="card-body text-center">
                    <span class="h1">{{$dispatch}}</span>
                </div>
            </div>
        </div>
    </div>

    <canvas id="graficos" width="400" height="150">

    </canvas>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script type="text/javascript">
        $(document).ready(() =>{
            var myBarChart = new Chart(document.getElementById('graficos').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @php echo json_encode(array_keys($graph)) @endphp,
                    datasets: [{
                        label: 'R$',
                        barPercentage: 1.1,
                        backgroundColor: 'rgba(50, 190, 82, 0.25)',
                        borderColor: 'rgba(50, 190, 82, 0.5)',
                        data: @php echo json_encode(array_values($graph)) @endphp,
                        borderWidth: 2
                    }],
                    options: {
                        beginAtZero: true
                    }
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    </script>
@endsection
