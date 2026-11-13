<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Внутреннее уведомление сотрудникам о новой заявке с сайта.
 * Тексты намеренно на русском и не зависят от локали посетителя.
 */
class NewLeadMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Lead $lead) {}

    public function envelope(): Envelope
    {
        $subject = trim((string) $this->lead->subject);
        $label = $subject !== '' ? ': '.$subject : '';

        return new Envelope(
            subject: 'Новая заявка с сайта'.$label,
            replyTo: $this->replyToAddresses(),
        );
    }

    public function content(): Content
    {
        return new Content(view: 'mail.new-lead');
    }

    /**
     * Чтобы можно было ответить посетителю прямо из письма.
     *
     * @return list<Address>
     */
    private function replyToAddresses(): array
    {
        $email = trim((string) $this->lead->email);
        $name = trim((string) $this->lead->name);

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [];
        }

        return [new Address($email, $name !== '' ? $name : null)];
    }
}
