<?php

namespace App\Filament\Resources;

use App\Enums\ExperienceCategory;
use App\Enums\WorkType;
use App\Filament\Resources\ExperienceResource\Pages;
use App\Models\Experience;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExperienceResource extends Resource
{
    use Translatable;

    protected static ?string $model = Experience::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 20;
    protected static ?string $modelLabel = 'Expérience';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Poste')->schema([
                Forms\Components\TextInput::make('position')
                    ->label('Titre du poste')
                    ->required(),
                Forms\Components\TextInput::make('company')
                    ->label('Entreprise')
                    ->required(),
                Forms\Components\TextInput::make('company_url')
                    ->label('Site web entreprise')
                    ->url(),
                Forms\Components\FileUpload::make('company_logo')
                    ->label('Logo entreprise')
                    ->image()
                    ->directory('experiences'),
            ])->columns(2),

            Forms\Components\Section::make('Traductions')->schema([
                Forms\Components\TextInput::make('position_translatable')
                    ->label('Poste (traduit)'),
                Forms\Components\TextInput::make('company_translatable')
                    ->label('Entreprise (traduite)'),
                Forms\Components\Textarea::make('description_translatable')
                    ->label('Description (traduite)')
                    ->rows(4),
            ])->columns(1)->collapsible(),

            Forms\Components\Section::make('Détails')->schema([
                Forms\Components\DatePicker::make('start_date')
                    ->label('Date de début')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label('Date de fin')
                    ->helperText('Laisser vide si poste actuel'),
                Forms\Components\Select::make('category')
                    ->label('Catégorie')
                    ->options(ExperienceCategory::class)
                    ->required(),
                Forms\Components\Select::make('work_type')
                    ->label('Type de travail')
                    ->options(WorkType::class)
                    ->default('on_site'),
                Forms\Components\TextInput::make('location')
                    ->label('Lieu'),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Technologies & Paramètres')->schema([
                Forms\Components\Select::make('technologies')
                    ->label('Technologies')
                    ->relationship('technologies', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('order')
                    ->label('Ordre')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Actif')
                    ->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('company_logo')->label('')->circular(),
                Tables\Columns\TextColumn::make('position')->label('Poste')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('company')->label('Entreprise')->searchable(),
                Tables\Columns\TextColumn::make('category')->label('Catégorie')->badge(),
                Tables\Columns\TextColumn::make('start_date')->label('Début')->date('M Y')->sortable(),
                Tables\Columns\TextColumn::make('end_date')->label('Fin')->date('M Y')->placeholder('Présent'),
                Tables\Columns\IconColumn::make('is_active')->label('Actif')->boolean(),
            ])
            ->defaultSort('start_date', 'desc')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Catégorie')
                    ->options(ExperienceCategory::class),
                Tables\Filters\TernaryFilter::make('is_active')->label('Actif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExperiences::route('/'),
            'create' => Pages\CreateExperience::route('/create'),
            'edit' => Pages\EditExperience::route('/{record}/edit'),
        ];
    }
}