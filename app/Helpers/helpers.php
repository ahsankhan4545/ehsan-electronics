<?php

if (! function_exists('money')) {
    /**
     * Format amount in Pakistani Rupees.
     */
    function money(float|int|string|null $amount): string
    {
        return 'Rs '.number_format((float) $amount, 0);
    }
}

if (! function_exists('payment_method_label')) {
    function payment_method_label(string $method): string
    {
        return app(\App\Services\PaymentService::class)->label($method);
    }
}
