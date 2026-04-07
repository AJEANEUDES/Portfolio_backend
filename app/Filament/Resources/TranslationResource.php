<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TranslationResource\Pages;
use App\Models\Translation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TranslationResource extends Resource
{
    protected static ?string $model = Translation::class;
    protected static ?string $navigationIcon = 'heroicon-o-language';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 90;
    protected static ?string $modelLabel = 'Traduction';
    protected static ?string $pluralModelLabel = 'Traductions';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Clé technique')
                    ->disabled()
                    ->helperText('Identifiant utilisé dans le code'),
                Forms\Components\TextInput::make('group')
                    ->label('Groupe')
                    ->disabled(),
                Forms\Components\Textarea::make('value_fr')
                    ->label('Valeur (Français)')
                    ->required()
                    ->rows(2)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('translations.en')
                    ->label('Anglais')
                    ->rows(2)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('translations.es')
                    ->label('Espagnol')
                    ->rows(2)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->label('Description (optionnel)')
                    ->helperText('Pour te rappeler où ce texte s\'affiche')
                    ->rows(2)
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group')
                    ->label('Groupe')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                Tables\Columns\TextColumn::make('key')
                    ->label('Clé')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('value_fr')
                    ->label('Français')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('translations.en')
                    ->label('Anglais')
                    ->limit(50)
                    ->getStateUsing(fn ($record) => $record->translations['en'] ?? '—'),
            ])
            ->defaultSort('group')
            ->groups([
                Tables\Grouping\Group::make('group')->label('Groupe'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->label('Groupe')
                    ->options(fn () => Translation::query()
                        ->select('group')
                        ->distinct()
                        ->pluck('group', 'group')
                        ->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTranslations::route('/'),
            'edit'  => Pages\EditTranslation::route('/{record}/edit'),
        ];
    }
}