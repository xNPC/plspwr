@php
    $rows = [
        'Имя'        => $lead->name,
        'Компания'   => $lead->company,
        'E-mail'     => $lead->email,
        'Телефон'    => $lead->phone,
        'Тема'       => $lead->subject,
        'Страница'   => $lead->page_url,
        'Дата'       => optional($lead->created_at)->format('d.m.Y H:i'),
    ];

    $rows = array_filter($rows, static fn ($value) => trim((string) $value) !== '');
@endphp
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Новая заявка с сайта</title>
</head>
<body style="margin:0;padding:24px;background:#f1f5f9;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;color:#0f172a;">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0;">
        <tr>
            <td style="padding:24px 28px;background:#0b1220;color:#ffffff;">
                <div style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#7dd3fc;">{{ config('app.name') }}</div>
                <h1 style="margin:8px 0 0;font-size:20px;line-height:1.3;font-weight:600;">Новая заявка с сайта</h1>
            </td>
        </tr>
        <tr>
            <td style="padding:24px 28px;">
                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px;line-height:1.5;">
                    @foreach ($rows as $label => $value)
                        <tr>
                            <td style="padding:6px 12px 6px 0;color:#64748b;white-space:nowrap;vertical-align:top;width:110px;">{{ $label }}</td>
                            <td style="padding:6px 0;color:#0f172a;">
                                @if ($label === 'E-mail')
                                    <a href="mailto:{{ $value }}" style="color:#0284c7;text-decoration:none;">{{ $value }}</a>
                                @elseif ($label === 'Телефон')
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', (string) $value) }}" style="color:#0284c7;text-decoration:none;">{{ $value }}</a>
                                @elseif ($label === 'Страница')
                                    <a href="{{ $value }}" style="color:#0284c7;text-decoration:none;word-break:break-all;">{{ $value }}</a>
                                @else
                                    {{ $value }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div style="margin-top:20px;padding-top:20px;border-top:1px solid #e2e8f0;">
                    <div style="font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#64748b;margin-bottom:8px;">Сообщение</div>
                    <div style="font-size:14px;line-height:1.6;color:#0f172a;white-space:normal;">{!! nl2br(e($lead->message)) !!}</div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="padding:16px 28px;background:#f8fafc;border-top:1px solid #e2e8f0;font-size:12px;color:#64748b;">
                Заявка сохранена в админке: {{ url('/admin') }} → «Заявки».
            </td>
        </tr>
    </table>
</body>
</html>
