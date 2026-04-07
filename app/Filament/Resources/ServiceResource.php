<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use App\Models\Technology;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    use Translatable;

    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informations principales')->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->maxLength(100),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->required()
                    ->maxLength(500)
                    ->rows(3),
                Forms\Components\FileUpload::make('icon')
                    ->label('Icône')
                    ->image()
                    ->directory('services'),
            ])->columns(1),

            Forms\Components\Section::make('Traductions')->schema([
                Forms\Components\TextInput::make('title_translatable')
                    ->label('Titre (traduit)'),
                Forms\Components\Textarea::make('description_translatable')
                    ->label('Description (traduite)')
                    ->rows(3),
            ])->columns(1)->collapsible(),

            Forms\Components\Section::make('Technologies & Paramètres')->schema([
                Forms\Components\Select::make('technologies')
                    ->label('Technologies associées')
                    ->relationship('technologies', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('order')
                    ->label('Ordre d\'affichage')
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
                Tables\Columns\ImageColumn::make('icon')->label('')->circular(),
                Tables\Columns\TextColumn::make('title')->label('Titre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description')->label('Description')->limit(50),
                Tables\Columns\TextColumn::make('technologies.name')->label('Technologies')->badge(),
                Tables\Columns\IconColumn::make('is_active')->label('Actif')->boolean(),
                Tables\Columns\TextColumn::make('order')->label('Ordre')->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}