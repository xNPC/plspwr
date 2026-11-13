@php
    /** @var \App\Models\Lead $lead */
    $isRead = (bool) ($lead->is_read ?? false);
    $subject = $lead->subject ?? __('Subject');
@endphp

<div class="lead-view p-3 py-4">
    {{-- Header: subject + status + date --}}
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
        <h4 class="mb-0 fw-semibold text-break">{{ $subject }}</h4>
        <span class="badge rounded-pill text-bg-{{ $isRead ? 'secondary' : 'danger' }} text-uppercase small py-1 px-3">
            {{ $isRead ? __('Read') : __('Unread') }}
        </span>
    </div>

    <div class="mb-4 small text-secondary">
        <x-orchid-icon path="bs.calendar3" class="me-1"/>
        {{ $lead->created_at?->format('d.m.Y H:i') }}
    </div>

    <hr class="my-4">

    {{-- Contact info --}}
    <dl class="row row-cols-1 g-0 mb-0">
        <div class="col-12 d-flex flex-wrap align-items-baseline py-3 border-bottom">
            <dt class="col-4 col-sm-3 fw-semibold text-secondary">{{ __('Name') }}</dt>
            <dd class="col-8 col-sm-9 mb-0 text-break">{{ $lead->name }}</dd>
        </div>

        <div class="col-12 d-flex flex-wrap align-items-baseline py-3 border-bottom">
            <dt class="col-4 col-sm-3 fw-semibold text-secondary">{{ __('Company') }}</dt>
            <dd class="col-8 col-sm-9 mb-0 text-break">{{ $lead->company ?: '—' }}</dd>
        </div>

        <div class="col-12 d-flex flex-wrap align-items-baseline py-3 border-bottom">
            <dt class="col-4 col-sm-3 fw-semibold text-secondary">{{ __('Email') }}</dt>
            <dd class="col-8 col-sm-9 mb-0">
                @if ($lead->email)
                    <a href="mailto:{{ $lead->email }}" class="link-primary">{{ $lead->email }}</a>
                @else
                    —
                @endif
            </dd>
        </div>

        <div class="col-12 d-flex flex-wrap align-items-baseline py-3 border-bottom">
            <dt class="col-4 col-sm-3 fw-semibold text-secondary">{{ __('Phone') }}</dt>
            <dd class="col-8 col-sm-9 mb-0">
                @if ($lead->phone)
                    <a href="tel:{{ preg_replace('/[^+\d]/', '', $lead->phone) }}" class="link-primary">{{ $lead->phone }}</a>
                @else
                    —
                @endif
            </dd>
        </div>
    </dl>

    {{-- Message --}}
    @if ($lead->message)
        <div class="mt-5">
            <div class="fw-semibold text-secondary mb-2">{{ __('Message') }}</div>
            <div class="p-4 rounded bg-body-tertiary text-body" style="white-space: pre-wrap; word-break: break-word;">{{ $lead->message }}</div>
        </div>
    @endif
</div>
