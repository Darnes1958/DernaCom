<?php

namespace App\Livewire;

use App\Filament\Resources\VictimResource;
use App\Models\Family;
use App\Models\Tribe;
use App\Models\Victim;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\On;


class FamWidget extends BaseWidget
{
    protected int | string | array $columnSpan=1;
    protected static ?int $sort=3;
  public  $family_show_id=null;



  #[On('take_family_show')]
  public function take_family_show($family_show_id){
    $this->family_show_id=$family_show_id;
  }
    public function table(Table $table): Table
    {
        return $table
            ->query(function (Family $tribe) {
                $tribe=Family::query()->where('nation','ليبيا')
                  ->when($this->family_show_id,function ($q){
                    $q->where('familyshow_id',$this->family_show_id);
                  })
                 ;
                return $tribe;
            }
            )
            ->queryStringIdentifier('families')
            ->heading(new HtmlString('<div class="text-primary-400 text-lg">اللقب</div>'))
            ->defaultPaginationPageOption(5)

            ->defaultSort('victim_count','desc')
            ->striped()
            ->columns([
                TextColumn::make('FamName')
                ->sortable()
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
