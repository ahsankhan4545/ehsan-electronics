<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Manual payment details (no merchant API)
    |--------------------------------------------------------------------------
    | Customer pays via EasyPaisa (or COD), then you mark Paid in admin.
    | Bank transfer is disabled — keep PAYMENT_BANK_ENABLED=false.
    */

    'bank' => [
        'enabled' => (bool) env('PAYMENT_BANK_ENABLED', false),
        'bank_name' => env('PAYMENT_BANK_NAME', 'HBL'),
        'account_title' => env('PAYMENT_BANK_ACCOUNT_TITLE', 'Ehsan Electronics'),
        'account_number' => env('PAYMENT_BANK_ACCOUNT_NUMBER', ''),
        'iban' => env('PAYMENT_BANK_IBAN', ''),
    ],

    'easypaisa' => [
        'enabled' => (bool) env('PAYMENT_EASYPAISA_ENABLED', true),
        'account_title' => env('PAYMENT_EASYPAISA_TITLE', 'Ehsan Electronics'),
        'number' => env('PAYMENT_EASYPAISA_NUMBER', '03305952206'),
    ],

];
