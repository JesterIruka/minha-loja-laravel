<?php

namespace App\Console\Commands;

use App\RatingToken;
use App\Sale;
use App\Traits\TotalVoiceTrait;
use Cagartner\CorreiosConsulta\CorreiosConsulta;
use Cagartner\CorreiosConsulta\Facade;
use Cagartner\CorreiosConsulta\ServiceProvider;
use Illuminate\Console\Command;

class CorreiosRefresh extends Command
{

    use TotalVoiceTrait;

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
                $res = $this->track($sale->shipping_code);
                if (strpos($res, 'Objeto entregue ao destinat') !== false) {
                    $sale->update(['status'=>Sale::ENTREGUE]);

                    $rt = RatingToken::create(['token'=>hash('sha256', serialize($sale))]);

                    $message = config('store.messages.sms.avaliacao');
                    $message = str_replace('%s', $rt->token, $message);
                    $this->enviarSMS($sale->client_phone, $message);
                }
            }
        }
    }

    public function track($code)
    {
        return file_get_contents("https://www.websro.com.br/correios.php?P_COD_UNI=$code");
    }
}
