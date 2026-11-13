<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Platform;

use App\Models\Lead;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class RecentLeadsListLayout extends Table
{
    public $target = 'recentLeads';

    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))->cantHide(),
            TD::make('email', __('Email')),
            TD::make('phone', __('Phone')),
            TD::make('subject', __('Subject')),
            TD::make('created_at', __('Received'))->sort(),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Lead $lead) => Link::make(__('View'))
                    ->route('platform.content.leads')
                    ->icon('bs.arrow-right')),
        ];
    }
}
