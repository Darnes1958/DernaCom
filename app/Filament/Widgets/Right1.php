<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class Right1 extends Widget
{
    protected static string $view = 'filament.widgets.right1';
    public static function canView(): bool
    {
        return true;
    }
}
