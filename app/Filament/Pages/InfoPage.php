<?php

namespace App\Filament\Pages;

use App\Models\Balag;
use App\Models\Bedon;
use App\Models\BigFamily;
use App\Models\Dead;
use App\Models\Family;
use App\Models\Familyshow;
use App\Models\Mafkoden;
use App\Models\Street;
use App\Models\Tarkeba;
use App\Models\VicTalent;
use App\Models\Victim;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InfoPage extends Page implements HasTable,HasForms
{
    use InteractsWithTable,InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.info-page';
    protected ?string $heading="";
    protected static ?string $navigationLabel='استفسار وبحث عن ضحايا الفيضان';


    public $familyshow_id;
    public $family_id=null;


    public $tarkeba=null;
    public $families;
    public $big_families;

    public $street_id=null;
    public $show='all';
    public $mother;
    public $count;
    public $notes=true;

    static $ser=0;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('familyshow_id')
                            ->hiddenLabel()
                            ->prefix('العائلة')
                            ->options(function () {
                                return Familyshow::query()->pluck('name', 'id');
                            })
                            ->preload()
                            ->live()
                            ->searchable()
                            ->columnSpan(2)
                            ->afterStateUpdated(function ($state){
                                $this->familyshow_id=$state;
                                $this->family_id=null;
                                $this->mother=Victim::where('familyshow_id',$state)->where('is_mother',1)->pluck('id')->all();
                            }),
                        Select::make('family_id')
                            ->hiddenLabel()
                            ->prefix('اللقب')
                            ->hidden(function (){
                                return $this->familyshow_id && Family::where('familyshow_id',$this->familyshow_id)->count()<=1;
                            })
                            ->options(function () {
                                if ($this->familyshow_id )
                                    return Family::query()->whereIn('familyshow_id',Familyshow::where('id',$this->familyshow_id)->pluck('id'))->pluck('FamName', 'id');
                                return Family::query()->pluck('FamName', 'id');
                            })
                            ->preload()
                            ->live()
                            ->searchable()
                            ->columnSpan(2)
                            ->afterStateUpdated(function ($state){
                                $this->family_id=$state;
                                $this->mother=Victim::where('family_id',$state)->where('is_mother',1)->pluck('id')->all();
                            }),

                        Select::make('street_id')
                            ->hiddenLabel()
                            ->prefix('العنوان')
                            ->options(Street::all()->pluck('StrName','id'))
                            ->preload()
                            ->live()
                            ->searchable()
                            ->columnSpan(2)
                            ->afterStateUpdated(function ($state){
                                $this->street_id=$state;
                            }),


                        Radio::make('show')
                            ->inline()
                            ->hiddenLabel()
                            ->inlineLabel(false)
                            ->reactive()
                            ->live()
                            ->columnSpan(3)
                            ->default('all')
                            ->afterStateUpdated(function ($state){
                                $this->show=$state;
                            })
                            ->options([
                                'all'=>'الكل',
                                'parent'=> 'أباء وأمهات',
                                'single'=>'افراد',
                                'father_only'=>'أباء',
                                'mother_only'=>'أمهات',
                            ]),






                    ])
                    ->columns(8),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table

            ->query(function (){
                return
                    Victim::query()
                        ->when($this->familyshow_id ,function($q){
                            $q->where('familyshow_id',$this->familyshow_id);
                        })
                        ->when($this->family_id ,function($q){
                            $q->where('family_id',$this->family_id);
                        })
                        ->when($this->street_id,function($q){
                            $q->where('street_id',$this->street_id);
                        })
                        ->when($this->show=='parent',function ($q){
                            $q->where(function ($q){
                                $q->where('is_father',1)
                                    ->orwhere('is_mother',1);
                            });
                        })
                        ->when($this->show=='father_only',function ($q){
                            $q->where('is_father',1);
                        })
                        ->when($this->show=='mother_only',function ($q){
                            $q->where('is_mother',1);
                        })
                        ->when($this->show=='single',function ($q){
                            $q->where(function ($q){
                                $q->where('is_father',null)->orwhere('is_father',0);
                            })
                                ->where(function ($q){
                                    $q->where('is_mother',null)->orwhere('is_mother',0);
                                })
                                ->where(function ($q){
                                    $q->where('father_id',null)->orwhere('father_id',0);
                                })
                                ->when($this->family_id,function ($q){

                                    $q->where(function ( $query) {
                                        $query->where('mother_id', null)
                                            ->orwhere('mother_id', 0)
                                            ->orwhereNotIn('mother_id',$this->mother);
                                    });
                                });
                        })
                        ->orderBy('familyshow_id')
                        ->orderBy('family_id');

            })
            ->columns([
                TextColumn::make('FullName')
                    ->label('الاسم بالكامل')
                    ->sortable()
                    ->searchable()
                    ->description(function (Victim $record){
                        $who='';
                        if (!$record->sonOfMother) {

                            $bed = null;
                            $maf = null;
                            $ded = null;
                            $bal = null;
                            if ($record->balag) $bal = Balag::find($record->balag);
                            if ($record->dead) $ded = Dead::find($record->dead);
                            if ($record->bedon) $bed = Bedon::find($record->bedon);
                            if ($record->mafkoden) $maf = Mafkoden::find($record->mafkoden);

                            if ($bed || $maf || $ded || $bal) {
                                if ($bal && $bal->mother) $who = 'اسم الأم : ' . $bal->mother;
                                if ($who=='' && $ded && $ded->mother) $who = 'اسم الأم : ' . $ded->mother;
                                if ($who=='' && $bed && $bed->mother) $who = 'اسم الأم : ' . $bed->mother;
                                if ($who=='' && $maf && $maf->mother) $who = $who . 'اسم الأم : ' . $maf->mother;

                            }
                        }
                        if ($record->notes) $who=$who.' ('.$record->notes.')';

                        return $who;
                    })

                    ->formatStateUsing(fn (Victim $record): View => view(
                        'filament.pages.full-data',
                        ['record' => $record],
                    ))
                    ->searchable(),
                TextColumn::make('year')
                    ->label('مواليد')   ,
                TextColumn::make('Familyshow.name')
                    ->label('العائلة')
                    ->sortable()
                    ->toggleable()

                    ->searchable(),
                TextColumn::make('Family.FamName')
                    ->label('التسمية')
                    ->sortable()
                    ->toggleable()
                    ->hidden(function (){return $this->family_id!=null;})
                    ->searchable(),

                TextColumn::make('Street.StrName')
                    ->label('العنوان')
                    ->hidden(function (){return $this->street_id!=null;})
                    ->toggleable()
                    ->sortable()
                    ->searchable(),



                ImageColumn::make('image')
                    ->toggleable()

                    ->label('')
                    ->circular(),

            ])
            ->actions([
                Action::make('View Information')
                    ->iconButton()
                    ->modalHeading('')
                    ->modalWidth(MaxWidth::FiveExtraLarge)
                    ->icon('heroicon-s-eye')
                    ->modalSubmitAction(false)
                    ->modalCancelAction(fn (StaticAction $action) => $action->label('عودة'))
                    ->infolist([
                        \Filament\Infolists\Components\Section::make()
                            ->schema([
                                \Filament\Infolists\Components\Section::make()
                                    ->schema([
                                        TextEntry::make('FullName')
                                            ->color(function (Victim $record){
                                                if ($record->male=='ذكر') return 'primary';  else return 'Fuchsia';})
                                            ->columnSpanFull()
                                            ->weight(FontWeight::ExtraBold)
                                            ->size(TextEntry\TextEntrySize::Large)
                                            ->label(''),
                                        TextEntry::make('sonOfFather.FullName')
                                            ->visible(function (Victim $record){
                                                return $record->father_id;
                                            })
                                            ->color('info')
                                            ->label('والده')
                                            ->size(TextEntry\TextEntrySize::Large)

                                            ->columnSpanFull(),
                                        TextEntry::make('sonOfMother.FullName')
                                            ->visible(function (Victim $record){
                                                return $record->mother_id;
                                            })
                                            ->color('Fuchsia')
                                            ->label('والدته')
                                            ->size(TextEntry\TextEntrySize::Large)

                                            ->columnSpanFull(),

                                        TextEntry::make('husband.FullName')
                                            ->visible(function (Victim $record){
                                                return $record->wife_id;
                                            })
                                            ->color('Fuchsia')
                                            ->label('زوجته')
                                            ->size(TextEntry\TextEntrySize::Large)
                                            ->separator(',')
                                            ->columnSpanFull(),
                                        TextEntry::make('husband2.FullName')
                                            ->visible(function (Victim $record){
                                                return $record->wife2_id;
                                            })
                                            ->color('Fuchsia')
                                            ->label('زوجته الثانية')
                                            ->size(TextEntry\TextEntrySize::Large)
                                            ->columnSpanFull(),
                                        TextEntry::make('wife.FullName')
                                            ->visible(function (Victim $record){
                                                return $record->husband_id;
                                            })
                                            ->label('زوجها')
                                            ->badge()
                                            ->separator(',')
                                            ->columnSpanFull(),

                                        TextEntry::make('father.Name1')
                                            ->visible(function (Victim $record){
                                                return $record->is_father;
                                            })
                                            ->label('أبناءه')
                                            ->color(function( )  {
                                                self::$ser++;

                                                switch (self::$ser){
                                                    case 1: $c='success';break;
                                                    case 2: $c='info';break;
                                                    case 3: $c='yellow';break;
                                                    case 4: $c='rose';break;
                                                    case 5: $c='blue';break;
                                                    case 6: $c='Fuchsia';break;
                                                    default: $c='primary';break;
                                                }
                                                return $c;

                                            })
                                            ->badge()
                                            ->separator(',')
                                            ->columnSpanFull(),
                                        TextEntry::make('mother.Name1')
                                            ->visible(function (Victim $record){
                                                return $record->is_mother;
                                            })
                                            ->label('أبناءها')
                                            ->badge()
                                            ->separator(',')
                                            ->columnSpanFull(),

                                        TextEntry::make('Family.FamName')
                                            ->color('info')
                                            ->label('العائلة'),
                                        TextEntry::make('Family.Tribe.TriName')
                                            ->color('info')
                                            ->label('القبيلة'),
                                        TextEntry::make('Street.StrName')
                                            ->color('info')
                                            ->label('العنوان'),
                                        TextEntry::make('Street.Area.AreaName')
                                            ->color('info')
                                            ->label('المحلة'),

                                        TextEntry::make('Qualification.name')
                                            ->visible(function (Model $record){
                                                return $record->qualification_id;
                                            })
                                            ->color('info')
                                            ->label('المؤهل'),
                                        TextEntry::make('Job.name')
                                            ->visible(function (Model $record){
                                                return $record->job_id;
                                            })
                                            ->color('info')
                                            ->label('الوظيفة'),
                                        TextEntry::make('VicTalent.Talent.name')
                                            ->visible(function (Model $record){
                                                return VicTalent::where('victim_id',$record->id)->exists() ;
                                            })

                                            ->color('info')
                                            ->label('المواهب'),
                                        TextEntry::make('notes')
                                            ->label('')

                                    ])
                                    ->columns(2)
                                    ->columnSpan(2),

                                ImageEntry::make('image')
                                    ->label('')

                                    ->height(400)
                                    ->square()
                                    ->columnSpan(2)


                            ])->columns(4)
                    ])
                    ->slideOver(),
            ])
            ;
    }
}
