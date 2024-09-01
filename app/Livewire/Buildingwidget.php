<?php

namespace  App\Livewire;

use App\Models\Road;
use App\Models\Street;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\On;


class Buildingwidget extends BaseWidget
{
    protected int | string | array $columnSpan=1;
    protected static ?int $sort=4;
    public $area_id=null;
    public $road_id=null;
    public $areaName=null;
    public $pre=null;

    #[On('take_road')]
    public function take_road($road_id,$areaName){
        $this->road_id=$road_id;
        $this->areaName=$areaName;
        $this->area_id=null;
        $this->pre=$this->areaName;
    }
    #[On('take_area')]
    public function take_area($area_id,$areaName){
        $this->area_id=$area_id;
        $this->areaName=$areaName;
        $this->road_id=null;
        $this->pre=$this->areaName;
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(function (Street $tribe) {
                $tribe=Street::where('building',1)
                    ->when($this->road_id,function ($q){
                        $q->where('road_id',$this->road_id);
                    })

                    ->when($this->area_id,function ($q){
                        $q->where('area_id',$this->area_id);
                    });
                return $tribe;
            }
            )
            ->heading(function () {return new HtmlString('<div class="text-primary-400 text-lg ">'.$this->pre.'</div>');} )
            ->defaultPaginationPageOption(16)
            ->paginationPageOptions([5,10,16,25,50,100])

            ->queryStringIdentifier('building')
            ->defaultSort('victim_count','desc')
            ->striped()
            ->columns([
                TextColumn::make('StrName')
                    ->sortable()
                    ->color('blue')
                    ->searchable()
                    ->label('العمارة'),
                TextColumn::make('victim_count')
                    ->color('warning')
                    ->sortable()
                    ->label('العدد')
                    ->counts('Victim'),


            ]);
    }
}
