<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestMailCommand extends Command
{
    protected $signature = 'mail:test {email? : Recipient address}';

    protected $description = 'Send a test email using the configured mailer (proves live delivery)';

    public function handle(): int
    {
        $to = $this->argument('email') ?: config('mail.from.address');

        $this->info('Mailer: '.config('mail.default'));
        $this->info('From: '.config('mail.from.address'));
        $this->info('To: '.$to);

        try {
            Mail::raw(
                'Ehsan Electronics mail test at '.now()->toDateTimeString().' (mailer='.config('mail.default').')',
                function ($message) use ($to) {
                    $message->to($to)->subject('Ehsan Electronics — mail test');
                }
            );
        } catch (\Throwable $e) {
            $this->error('FAILED: '.$e->getMessage());

            return self::FAILURE;
        }

        $this->info('SENT_OK');

        return self::SUCCESS;
    }
}
