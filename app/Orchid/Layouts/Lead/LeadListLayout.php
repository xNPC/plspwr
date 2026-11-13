<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Lead;

use App\Models\Lead;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LeadListLayout extends Table
{
    public $target = 'leads';

    public function columns(): array
    {
        return [
            TD::make('is_read', '')
                ->render(fn (Lead $lead) => $lead->is_read ? '' : '•')
                ->align(TD::ALIGN_CENTER)
                ->width('30px'),

            TD::make('name', __('Name'))
                ->sort()
                ->cantHide(),

            TD::make('email', __('Email'))
                ->sort(),

            TD::make('phone', __('Phone')),

            TD::make('subject', __('Subject')),

            TD::make('created_at', __('Received'))
                ->sort(),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('120px')
                ->render(fn (Lead $lead) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        ModalToggle::make(__('View'))
                            ->modal('leadViewModal')
                            ->method('viewLead', ['id' => $lead->id])
                            ->icon('bs.eye'),
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Delete this lead?'))
                            ->method('remove', ['id' => $lead->id]),
                    ])),
        ];
    }
}
