<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Manual payment details (no merchant API)
    |--------------------------------------------------------------------------
    | Customer pays to your personal bank / EasyPaisa, then you mark Paid in admin.
    */

    'bank' => [
        'enabled' => (bool) env('PAYMENT_BANK_ENABLED', true),
        'bank_name' => env('PAYMENT_BANK_NAME', 'HBL'),
        'account_title' => env('PAYMENT_BANK_ACCOUNT_TITLE', 'Ehsan Electronics'),
        'account_number' => env('PAYMENT_BANK_ACCOUNT_NUMBER', '0123456789012'),
        'iban' => env('PAYMENT_BANK_IBAN', 'PK00HABB0000000000000000'),
    ],

    'easypaisa' => [
        'enabled' => (bool) env('PAYMENT_EASYPAISA_ENABLED', true),
        'account_title' => env('PAYMENT_EASYPAISA_TITLE', 'Ehsan Electronics'),
        'number' => env('PAYMENT_EASYPAISA_NUMBER', '03001234567'),
    ],

];
