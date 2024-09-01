<?php

namespace App\Livewire;

use App\Models\Road;
use App\Models\Street;
use App\Models\Victim;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\HtmlString;

class NumbersWidget extends BaseWidget
{
    protected int | string | array $columnSpan='4';
    public $west;
    public $east;

    public function mount(){
        $this->west=Street::whereIn('road_id',Road::where('east_west','غرب الوادي')->pluck('id'))->pluck('id');
        $this->east=Street::whereIn('road_id',Road::where('east_west','شرق الوادي')->pluck('id'))->pluck('id');
    }
    protected function getStats(): array
    {
        return [
            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">العدد الكلي</span>'))
                ->value(new HtmlString('<span class="text-primary-500">'.Victim::count().'</span>')),
            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">ليبيين</span>'))
                ->value(new HtmlString('<span class="text-primary-500">'.Victim::whereNotin('family_id',[120,162,207,250,303,306,308,343,344,345,346,347,10375,10376,10377,10384])->count().'</span>')),
            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">أجانب</span>'))
                ->value(new HtmlString('<span class="text-primary-500">'.Victim::whereIn('family_id',[120,162,207,250,303,306,308,343,344,345,346,347,10375,10376,10377,10384])->count().'</span>')),
            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">ذكور</span>'))
                ->value(new HtmlString('<span class="text-primary-500">'.Victim::where('male','ذكر')->count().'</span>')),
            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">إناث</span>'))
                ->value(new HtmlString('<span class="text-danger-600">'.Victim::where('male','أنثي')->count().'</span>')),
            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">أب</span>'))
                ->value(new HtmlString('<span class="text-primary-500">'.Victim::where('is_father',1)->count().'</span>')),
            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">أم</span>'))
                ->value(new HtmlString('<span class="text-danger-600">'.Victim::where('is_mother',1)->count().'</span>')),
            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">وفاة أثناء العمل</span>'))
                ->value(new HtmlString('<span class="text-primary-500">'.Victim::
                    where('inWork',1)->count().'</span>')),
            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">منقذين</span>'))
                ->value(new HtmlString('<span class="text-primary-500">'.Victim::
                    where('inSave',1)->count().'</span>')),
            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">ضيوف</span>'))
                ->value(new HtmlString('<span class="text-primary-500">'.Victim::
                    where('guests',1)->count().'</span>')),

            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">غرب الوادي</span>'))
                ->value(new HtmlString('<span class="text-primary-500">'.Victim::
                    whereIn('street_id',$this->west)->count().'</span>')),

            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">شرق الوادي</span>'))
                ->value(new HtmlString('<span class="text-primary-500">'.Victim::
                    whereIn('street_id',$this->east)->count().'</span>')),
            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">وادي درنه</span>'))
                ->value(new HtmlString('<span class="text-primary-500">'.Victim::
                    whereIn('street_id',Street::where('road_id',15)->pluck('id'))->count().'</span>')),
            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">وادي الناقة</span>'))
                ->value(new HtmlString('<span class="text-primary-500">'.Victim::
                    whereIn('street_id',Street::where('road_id',16)->pluck('id'))->count().'</span>')),

            Stat::make('','')
                ->label(new HtmlString('<span class="text-white">غير محدد</span>'))
                ->value(new HtmlString('<span class="text-primary-500">'.Victim::
                    whereIn('street_id',Street::where('road_id',19)->pluck('id'))->count().'</span>')),

        ];
    }
}
