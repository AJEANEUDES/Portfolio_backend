<?php

namespace App\Filament\Resources;

use App\Enums\SocialPlatform;
use App\Filament\Resources\SocialLinkResource\Pages;
use App\Models\SocialLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SocialLinkResource extends Resource
{
    protected static ?string $model = SocialLink::class;
    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 95;
    protected static ?string $modelLabel = 'Lien social';
    protected static ?string $pluralModelLabel = 'Liens sociaux';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Select::make('platform')
                    ->label('Plateforme')
                    ->options(SocialPlatform::class)
                    ->required(),
                Forms\Components\TextInput::make('url')
                    ->label('URL')
                    ->required()
                    ->url(),
                Forms\Components\TextInput::make('label')
                    ->label('Libellé (optionnel)')
                    ->placeholder('Mon profil GitHub'),
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
                Tables\Columns\TextColumn::make('platform')->label('Plateforme')->badge()->sortable(),
                Tables\Columns\TextColumn::make('url')->label('URL')->limit(50),
                Tables\Columns\TextColumn::make('label')->label('Libellé'),
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
            'index' => Pages\ListSocialLinks::route('/'),
            'create' => Pages\CreateSocialLink::route('/create'),
            'edit' => Pages\EditSocialLink::route('/{record}/edit'),
        ];
    }
}