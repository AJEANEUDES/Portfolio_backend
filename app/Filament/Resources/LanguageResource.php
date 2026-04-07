<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LanguageResource\Pages;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;
    protected static ?string $navigationIcon = 'heroicon-o-language';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 100;
    protected static ?string $modelLabel = 'Langue';
    protected static ?string $pluralModelLabel = 'Langues';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informations')->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Code ISO')
                    ->placeholder('fr, en, es...')
                    ->maxLength(5)
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->label('Nom (anglais)')
                    ->placeholder('French')
                    ->required(),
                Forms\Components\TextInput::make('native_name')
                    ->label('Nom natif')
                    ->placeholder('Français')
                    ->required(),
                Forms\Components\TextInput::make('flag')
                    ->label('Drapeau (emoji)')
                    ->placeholder('🇫🇷'),
                Forms\Components\Toggle::make('is_default')
                    ->label('Langue par défaut'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
                Forms\Components\TextInput::make('order')
                    ->label('Ordre')
                    ->numeric()
                    ->default(0),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('flag')->label(''),
                Tables\Columns\TextColumn::make('code')->label('Code')->sortable(),
                Tables\Columns\TextColumn::make('native_name')->label('Langue')->sortable(),
                Tables\Columns\IconColumn::make('is_default')->label('Par défaut')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
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
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}