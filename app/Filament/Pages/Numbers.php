<?php

namespace App\Filament\Pages;

use App\Livewire\NumbersWidget;
use Filament\Pages\Page;

class Numbers extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.numbers';
    protected ?string $heading= '';
    protected static ?string $navigationLabel='اعداد الضحايا';
    public static function getWidgets(): array
    {
        return [
            NumbersWidget::class,

        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            NumbersWidget::make(),

        ];
    }
}
