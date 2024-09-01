<?php

namespace App\Filament\Pages;

use App\Models\Country;
use Filament\Pages\Page;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class CountryPage extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.country-page';
    protected ?string $heading='';
    protected static ?int $navigationSort=10;
    protected static ?string $navigationLabel='الدول';

    public function table(Table $table): Table
    {
        return $table
            ->query(function (Country $tribe) {
                $tribe=Country::where('name','!=',null);
                return $tribe;
            }
            )
            ->heading(new HtmlString('<div class="text-primary-400 text-lg">العدد حسب الدولة</div>'))
            ->paginated(false)
            ->queryStringIdentifier('countries')
            ->defaultSort('victim_count','desc')
            ->striped()
            ->columns([
                TextColumn::make('ت')
                    ->rowIndex(),
                TextColumn::make('name')
                    ->sortable()
                    ->color('blue')
                    ->searchable()
                    ->label('الدولة'),
                TextColumn::make('victim_count')
                    ->color('warning')
                    ->sortable()
                    ->label('العدد')
                    ->counts('Victim'),
                ImageColumn::make('image')
                    ->label(' ')
                    ->circular()
            ]);
    }

}
