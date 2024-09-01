<?php

namespace App\Filament\Pages;

use App\Livewire\FamilyShowWidget;
use App\Livewire\FamWidget;
use App\Livewire\VictimWidget;
use App\Models\Victim;
use Filament\Pages\Page;
use Livewire\Attributes\On;

class FamilyPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.family-page';
    protected ?string $heading='';
    protected static ?string $navigationLabel='العائلات';
    protected static ?int $navigationSort=9;
    public $showFamilyWidget=false;


    public function getFooterWidgetsColumns(): int | string | array
    {
        return 6;
    }

    protected function getFooterWidgets(): array
    {

            return [
                FamilyShowWidget::class,
                VictimWidget::class,
            ];

    }

}
