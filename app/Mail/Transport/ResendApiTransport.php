<?php

namespace App\Mail\Transport;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\MessageConverter;

/**
 * Sends mail through Resend's HTTPS API (port 443).
 * Required on Railway Hobby/Free — outbound SMTP (587/465) is blocked there.
 */
class ResendApiTransport extends AbstractTransport
{
    public function __construct(
        private readonly string $apiKey,
    ) {
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $from = $email->getFrom()[0] ?? null;
        $to = array_map(
            fn (Address $a) => $a->getAddress(),
            $email->getTo()
        );

        $payload = [
            'from' => $from
                ? trim(($from->getName() ? $from->getName().' ' : '').'<'.$from->getAddress().'>')
                : config('mail.from.address'),
            'to' => array_values($to),
            'subject' => $email->getSubject() ?? '(no subject)',
        ];

        if ($html = $email->getHtmlBody()) {
            $payload['html'] = $html;
        }

        if ($text = $email->getTextBody()) {
            $payload['text'] = $text;
        }

        $timeout = (int) env('MAIL_TIMEOUT', 8);
        if ($timeout < 1) {
            $timeout = 8;
        }

        $response = Http::withToken($this->apiKey)
            ->acceptJson()
            ->timeout($timeout)
            ->connectTimeout(min(5, $timeout))
            ->post('https://api.resend.com/emails', $payload);

        if ($response->failed()) {
            throw new \RuntimeException(
                'Resend API failed ('.$response->status().'): '.$response->body()
            );
        }
    }

    public function __toString(): string
    {
        return 'resend-api';
    }
}
