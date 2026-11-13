<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Lead;

use App\Models\Lead;
use App\Orchid\Layouts\Lead\LeadListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class LeadListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'leads' => Lead::orderByDesc('created_at')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Leads');
    }

    public function description(): ?string
    {
        return __('Messages submitted through the public contact/lead forms.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.leads'];
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [
            LeadListLayout::class,

            Layout::modal('leadViewModal', Layout::view('orchid.lead-view'))
                ->title(__('Lead'))
                ->deferred('viewLead')
                ->withoutApplyButton(),
        ];
    }

    public function viewLead(int $id): array
    {
        $lead = Lead::findOrFail($id);

        if (! $lead->is_read) {
            $lead->update(['is_read' => true]);
            $lead->setAttribute('is_read', false);
        }

        return [
            'lead' => $lead,
        ];
    }

    public function remove(int $id): RedirectResponse
    {
        Lead::findOrFail($id)->delete();

        Toast::info(__('Lead was removed.'));

        return redirect()->route('platform.content.leads');
    }
}
