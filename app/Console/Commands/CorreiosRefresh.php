<?php

namespace App\Console\Commands;

use App\Sale;
use Cagartner\CorreiosConsulta\CorreiosConsulta;
use Cagartner\CorreiosConsulta\Facade;
use Cagartner\CorreiosConsulta\ServiceProvider;
use Illuminate\Console\Command;

class CorreiosRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'correios:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rastreio todos os objetos pendentes e atualiza o banco de dados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sales = Sale::where('status', Sale::DESPACHADO)->select('id', 'shipping_code')->get();
        foreach ($sales as $sale) {
            if (preg_match('/[A-Z]{2}\d{9}[A-Z]{2}/', $sale->shipping_code)) { //Correios
                $res = $this->rastrear($sale->shipping_code);
                if (strpos($res, 'Objeto entregue ao destinat') !== false) {
                    $sale->update(['status'=>Sale::ENTREGUE]);
                }
            }
        }
    }

    public function rastrear($objeto)
    {
        return file_get_contents("https://linketrack.com/$objeto/html");
    }
}
