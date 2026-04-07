<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EducationResource\Pages;
use App\Models\Education;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EducationResource extends Resource
{
    use Translatable;

    protected static ?string $model = Education::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 40;
    protected static ?string $modelLabel = 'Formation';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Formation')->schema([
                Forms\Components\TextInput::make('degree')
                    ->label('Diplôme / Titre')
                    ->required(),
                Forms\Components\TextInput::make('institution')
                    ->label('Établissement')
                    ->required(),
                Forms\Components\TextInput::make('institution_url')
                    ->label('Site web établissement')
                    ->url(),
                Forms\Components\FileUpload::make('institution_logo')
                    ->label('Logo établissement')
                    ->image()
                    ->directory('educations'),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Date de début')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label('Date de fin')
                    ->helperText('Laisser vide si en cours'),
                Forms\Components\TextInput::make('mention')
                    ->label('Mention / GPA'),
                Forms\Components\TextInput::make('location')
                    ->label('Lieu'),
                Forms\Components\Textarea::make('description')
                    ->label('Description / Spécialisation')
                    ->rows(4)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Traductions')->schema([
                Forms\Components\TextInput::make('degree_translatable')
                    ->label('Diplôme (traduit)'),
                Forms\Components\TextInput::make('institution_translatable')
                    ->label('Établissement (traduit)'),
                Forms\Components\Textarea::make('description_translatable')
                    ->label('Description (traduite)')
                    ->rows(4),
            ])->columns(1)->collapsible(),

            Forms\Components\Section::make('Paramètres')->schema([
                Forms\Components\Select::make('technologies')
                    ->label('Compétences acquises')
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
                Tables\Columns\ImageColumn::make('institution_logo')->label('')->circular(),
                Tables\Columns\TextColumn::make('degree')->label('Diplôme')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('institution')->label('Établissement')->searchable(),
                Tables\Columns\TextColumn::make('start_date')->label('Début')->date('M Y')->sortable(),
                Tables\Columns\TextColumn::make('end_date')->label('Fin')->date('M Y')->placeholder('En cours'),
                Tables\Columns\TextColumn::make('mention')->label('Mention'),
                Tables\Columns\IconColumn::make('is_active')->label('Actif')->boolean(),
            ])
            ->defaultSort('start_date', 'desc')
            ->reorderable('order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEducation::route('/'),
            'create' => Pages\CreateEducation::route('/create'),
            'edit' => Pages\EditEducation::route('/{record}/edit'),
        ];
    }
}