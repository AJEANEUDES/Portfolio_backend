<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSectionResource\Pages;
use App\Models\SiteSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSectionResource extends Resource
{
    protected static ?string $model = SiteSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 85;
    protected static ?string $modelLabel = 'Section du site';
    protected static ?string $pluralModelLabel = 'Sections du site';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Section')->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Identifiant technique')
                    ->disabled()
                    ->helperText('Non modifiable — utilisé par le code frontend'),
                Forms\Components\TextInput::make('title')
                    ->label('Titre affiché')
                    ->required()
                    ->placeholder('Ex: Mes Compétences'),
                Forms\Components\Textarea::make('subtitle')
                    ->label('Sous-titre')
                    ->rows(2)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('order')
                    ->label('Ordre d\'affichage')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Section active')
                    ->helperText('Si désactivée, la section ne sera pas affichée sur le site')
                    ->default(true),
            ])->columns(2),

            Forms\Components\Section::make('Traductions')
                ->collapsible()
                ->collapsed()
                ->schema([
                    Forms\Components\Tabs::make('translations')
                        ->tabs([
                            Forms\Components\Tabs\Tab::make('Anglais')
                                ->schema([
                                    Forms\Components\TextInput::make('title_translatable.en')
                                        ->label('Titre (EN)'),
                                    Forms\Components\Textarea::make('subtitle_translatable.en')
                                        ->label('Sous-titre (EN)')
                                        ->rows(2),
                                ]),
                            Forms\Components\Tabs\Tab::make('Espagnol')
                                ->schema([
                                    Forms\Components\TextInput::make('title_translatable.es')
                                        ->label('Titre (ES)'),
                                    Forms\Components\Textarea::make('subtitle_translatable.es')
                                        ->label('Sous-titre (ES)')
                                        ->rows(2),
                                ]),
                        ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('key')
                    ->label('Clé')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Sous-titre')
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            // Pas de création ni suppression — les sections sont fixes
            // On peut juste les modifier et activer/désactiver
            ;
    }

    // Interdire la création manuelle
    public static function canCreate(): bool
    {
        return false;
    }

    // Interdire la suppression (pour éviter de casser le frontend)
    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSections::route('/'),
            'edit' => Pages\EditSiteSection::route('/{record}/edit'),
        ];
    }
}