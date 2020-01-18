<?php

return [
    'enabled'=>true,
    'email'=>env('PAGSEGURO_EMAIL'),
    'token'=>env('PAGSEGURO_TOKEN'),
    'notification_url'=>'https://yourwebsite.com/ipn/pagseguro'
];
