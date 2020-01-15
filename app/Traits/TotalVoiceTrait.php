<?php

namespace App\Traits;

use TotalVoice\Client as TotalVoiceClient;
use TotalVoice\Handler\Response;

trait TotalVoiceTrait
{

    private $client;

    public function __construct()
    {
        $this->client = new TotalVoiceClient(env('TOTALVOICE_TOKEN'));
    }

    public function enviarSMS($numero, $mensagem)
    {
        $numero = substr(preg_replace('/[^0-9.]/', '', $numero), 2);
        $response = $this->client->sms->enviar($numero, $mensagem);
        $response = json_decode($response->getContent());
        if ($response->sucesso) return true;
        else return $response->mensagem;
    }
}

