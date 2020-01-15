<?php


namespace App\Traits;


class Tester
{

    use TotalVoiceTrait;

    function teste($numero) {
        return $this->enviarSMS($numero, 'Olá, este é um teste!');
    }
}
