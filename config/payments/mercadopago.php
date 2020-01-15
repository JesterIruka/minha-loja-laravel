<?php

return [
    'enabled'=>true,
    'CLIENT_ID'=>env('MERCADOPAGO_CLIENT_ID'),
    'CLIENT_SECRET'=>env('MERCADOPAGO_CLIENT_SECRET'),
    'notification_url'=>'https://yourwebsite.com/ipn/mercadopago'
];
