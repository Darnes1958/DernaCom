<?php

namespace App\Livewire;

use App\Models\Family;
use App\Models\Familyshow;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\HtmlString;

class FamilyShowWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(function (Familyshow $familyshow) {
                $familyshow=Familyshow::query()->where('nation','ليبيا');
                return $familyshow;
            }
                // ...
            )
            ->queryStringIdentifier('familiesshow')
            ->heading(new HtmlString('<div class="text-primary-400 text-lg">العدد حسب العائلات</div>'))
            ->defaultPaginationPageOption(5)

            ->defaultSort('victim_count','desc')
            ->striped()
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->action(function (Familyshow $record){
                        $this->dispatch('take_family_show_id',family_show_id: $record->id);
                    })
                    ->color('blue')
                    ->searchable()
                    ->label('العائلة'),
                TextColumn::make('victim_count')
                    ->color('warning')
                    ->sortable()
                    ->label('العدد')
                    ->counts('Victim'),


            ]);

    }
}
