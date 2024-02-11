<?php

return [
    'key' => env('COINBASE_API_KEY'),
    'version' => env('COINBASE_VERSION', '2018-03-22'),
    'webhook-signature' => env('COINBASE_WEBHOOK_SIGNATURE'),
];
