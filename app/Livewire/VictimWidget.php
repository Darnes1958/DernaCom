<?php

namespace App\Livewire;

use App\Models\Balag;
use App\Models\Bedon;
use App\Models\Dead;
use App\Models\Family;
use App\Models\Mafkoden;
use App\Models\VicTalent;
use App\Models\Victim;
use Filament\Actions\StaticAction;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\On;

class VictimWidget extends BaseWidget
{
    protected int | string | array $columnSpan=5;
    public $family_show_id;
    static $ser=0;
    #[On('take_family_show_id')]
    public function take_family_show_id($family_show_id){
        $this->family_show_id=$family_show_id;
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(function (Victim $tribe) {
                $tribe=Victim::query()->where('familyshow_id',$this->family_show_id)

                ;
                return $tribe;
            }
            )
            ->queryStringIdentifier('families')
            ->heading(new HtmlString('<div class="text-primary-400 text-lg"> </div>'))
            ->defaultPaginationPageOption(10)
            ->striped()
            ->columns([
                TextColumn::make('FullName')
                    ->label('الاسم بالكامل')
                    ->sortable()
                    ->searchable()
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->formatStateUsing(fn (Victim $record): View => view(
                        'filament.pages.full-data',
                        ['record' => $record],
                    ))
                    ->searchable(),
                ImageColumn::make('image2')
                    ->toggleable()
                    ->stacked()
                    ->label('')
                    ->circular(),


            ])
            ->actions([
                Action::make('View Information')
                    ->iconButton()
                    ->modalHeading('')
                    ->modalWidth(MaxWidth::SevenExtraLarge)
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
                                            ->columnSpan(3)
                                            ->weight(FontWeight::ExtraBold)
                                            ->size(TextEntry\TextEntrySize::Large)
                                            ->label(''),
                                        TextEntry::make('year')
                                         ->visible(function (Victim $record){return $record->year!=null;})
                                         ->inlineLabel()
                                            ->color('rose')
                                         ->label(new HtmlString('<span style="color: yellow">مواليد</span>')),
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
                                    ->columns(4)
                                    ->columnSpan(2),

                                ImageEntry::make('image2')
                                    ->stacked()
                                    ->label('')

                                    ->height(500)

                                    ->columnSpan(2)


                            ])
                            ->columns(4)
                    ])
                    ->slideOver(),
            ]);
    }
}
