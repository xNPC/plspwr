<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\NewLeadMail;
use App\Models\Lead;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Отправка e-mail-уведомлений о новых заявках.
 *
 * Получатели задаются в админке (Настройки → «Получатели заявок»):
 * можно перечислить несколько адресов через запятую, точку с запятой,
 * пробел или с новой строки. Если поле пустое — используется
 * контактный e-mail сайта, затем MAIL_FROM_ADDRESS.
 */
class LeadNotifier
{
    public function __construct(private readonly SiteSettings $settings) {}

    /**
     * Список получателей уведомлений о заявках.
     *
     * @return list<string>
     */
    public function recipients(): array
    {
        $candidates = [
            (string) ($this->settings->get('leads.notify_emails') ?? ''),
            (string) ($this->settings->get('contacts.email') ?? ''),
            (string) config('mail.from.address', ''),
        ];

        foreach ($candidates as $candidate) {
            $emails = self::parseEmails($candidate);

            if ($emails !== []) {
                return $emails;
            }
        }

        return [];
    }

    /**
     * Отправить уведомление о заявке. Ошибки не пробрасываются:
     * заявка уже сохранена в БД, форма не должна падать из-за SMTP.
     */
    public function send(Lead $lead): void
    {
        $recipients = $this->recipients();

        if ($recipients === []) {
            Log::warning('Lead notification skipped: no recipients configured.', [
                'lead_id' => $lead->id,
            ]);

            return;
        }

        try {
            Mail::to($recipients)->send(new NewLeadMail($lead));
        } catch (Throwable $e) {
            Log::error('Lead notification failed: '.$e->getMessage(), [
                'lead_id' => $lead->id,
                'recipients' => $recipients,
            ]);
        }
    }

    /**
     * Разобрать строку с адресами в список валидных уникальных e-mail.
     *
     * @return list<string>
     */
    public static function parseEmails(?string $raw): array
    {
        $parts = preg_split('/[\s,;]+/', (string) $raw, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        $emails = [];

        foreach ($parts as $part) {
            $email = trim($part);

            if (filter_var($email, FILTER_VALIDATE_EMAIL) && ! in_array($email, $emails, true)) {
                $emails[] = $email;
            }
        }

        return $emails;
    }
}
