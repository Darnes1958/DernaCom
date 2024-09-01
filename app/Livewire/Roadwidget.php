<?php

namespace  App\Livewire;


use App\Models\Road;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

use Illuminate\Support\HtmlString;


class Roadwidget extends BaseWidget
{
  protected int | string | array $columnSpan = 1;
    protected static ?int $sort=2;


    public function table(Table $table): Table
    {
        return $table
            ->query(function (Road $tribe) {
                $tribe=Road::query()
                  ;
                return $tribe;
            }
            )
            ->queryStringIdentifier('roads')
            ->heading(new HtmlString('<div class="text-primary-400 text-lg">العدد حسب الشوارع الرئيسية</div>'))
            ->defaultPaginationPageOption(6)
            ->paginationPageOptions([6,10,16,25,50,100])


            ->defaultSort('victim_count','desc')
            ->striped()
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                  ->action(function (Road $record){
                    $this->dispatch('take_road',road_id: $record->id,areaName: $record->name);
                  })
                    ->color('blue')
                    ->searchable()
                    ->label('الشارع'),
                TextColumn::make('victim_count')
                    ->color('warning')
                    ->sortable()
                    ->label('العدد')
                    ->counts('Victim'),


            ]);
    }
}
