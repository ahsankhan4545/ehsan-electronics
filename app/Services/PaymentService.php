<?php

namespace App\Services;

class PaymentService
{
    /**
     * Process payment via COD or manual transfer methods.
     */
    public function process(string $method, float $amount, array $data = []): array
    {
        return match ($method) {
            'cod' => $this->processCod(),
            'easypaisa' => $this->processManual('easypaisa'),
            default => throw new \InvalidArgumentException('Invalid payment method.'),
        };
    }

    private function processCod(): array
    {
        return [
            'status' => 'pending',
            'payment_id' => null,
            'message' => 'Cash on Delivery order placed successfully.',
        ];
    }

    /**
     * Manual EasyPaisa — customer pays offline, admin confirms later.
     */
    private function processManual(string $method): array
    {
        return [
            'status' => 'awaiting_payment',
            'payment_id' => null,
            'message' => 'Order placed. Please send payment via EasyPaisa and wait for confirmation.',
        ];
    }

    public function label(string $method): string
    {
        return match ($method) {
            'cod' => 'Cash on Delivery',
            'bank_transfer' => 'Bank Transfer',
            'easypaisa' => 'EasyPaisa',
            'stripe' => 'Card Payment',
            default => strtoupper($method),
        };
    }

    public function isManual(string $method): bool
    {
        return $method === 'easypaisa';
    }
}
