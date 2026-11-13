<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Lead;
use Livewire\Component;

class LeadForm extends Component
{
    public ?string $name = null;

    public ?string $email = null;

    public ?string $phone = null;

    public ?string $company = null;

    public ?string $subject = null;

    public ?string $message = null;

    public bool $consent = false;

    public bool $sent = false;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:190'],
            'email' => ['nullable', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:190'],
            'subject' => ['nullable', 'string', 'max:190'],
            'message' => ['required', 'string', 'max:5000'],
            'consent' => ['accepted'],
        ];
    }

    public function submit(): void
    {
        $data = $this->validate();

        Lead::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'company' => $data['company'],
            'subject' => $data['subject'],
            'message' => $data['message'],
            'page_url' => url()->current(),
        ]);

        $this->reset([
            'name', 'email', 'phone', 'company', 'subject', 'message', 'consent',
        ]);
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.lead-form');
    }
}
