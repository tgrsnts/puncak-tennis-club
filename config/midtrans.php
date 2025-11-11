<?php

return [
    'server_key'    => env('MIDTRANS_SERVER_KEY'),
    'client_key'    => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => (bool) env('MIDTRANS_PRODUCTION', false),
    'expiry_minutes'=> (int) env('MIDTRANS_EXPIRY_MINUTES', 1440),
];
