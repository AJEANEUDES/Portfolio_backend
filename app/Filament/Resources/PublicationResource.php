<?php

namespace App\Filament\Resources;

use App\Enums\PublicationType;
use App\Filament\Resources\PublicationResource\Pages;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PublicationResource extends Resource
{
    use Translatable;

    protected static ?string $model = Publication::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 45;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Publication')->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Titre')
                    ->required(),
                Forms\Components\TextInput::make('authors')
                    ->label('Auteurs')
                    ->required()
                    ->placeholder('Nom1, A., Nom2, B.'),
                Forms\Components\Select::make('type')
                    ->label('Type')
                    ->options(PublicationType::class)
                    ->required(),
                Forms\Components\TextInput::make('venue')
                    ->label('Revue / Conférence'),
                Forms\Components\TextInput::make('year')
                    ->label('Année')
                    ->numeric()
                    ->required()
                    ->default(now()->year),
                Forms\Components\Select::make('project_id')
                    ->label('Projet associé')
                    ->relationship('project', 'name')
                    ->searchable()
                    ->preload(),
            ])->columns(2),

            Forms\Components\Section::make('Traductions')->schema([
                Forms\Components\TextInput::make('title_translatable')
                    ->label('Titre (traduit)'),
                Forms\Components\Textarea::make('abstract_translatable')
                    ->label('Résumé (traduit)')
                    ->rows(4),
            ])->columns(1)->collapsible(),

            Forms\Components\Section::make('Contenu')->schema([
                Forms\Components\Textarea::make('abstract')
                    ->label('Résumé / Abstract')
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('bibtex')
                    ->label('Citation BibTeX')
                    ->rows(4)
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Liens & Fichiers')->schema([
                Forms\Components\TextInput::make('doi_url')
                    ->label('Lien DOI')
                    ->url(),
                Forms\Components\FileUpload::make('pdf_file')
                    ->label('Fichier PDF')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('publications'),
            ])->columns(2),

            Forms\Components\Section::make('Paramètres')->schema([
                Forms\Components\Toggle::make('is_featured')
                    ->label('Mis en avant'),
                Forms\Components\TextInput::make('order')
                    ->label('Ordre')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Actif')
                    ->default(true),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Titre')->searchable()->sortable()->limit(50),
                Tables\Columns\TextColumn::make('authors')->label('Auteurs')->limit(30),
                Tables\Columns\TextColumn::make('type')->label('Type')->badge(),
                Tables\Columns\TextColumn::make('year')->label('Année')->sortable(),
                Tables\Columns\IconColumn::make('is_featured')->label('Vedette')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Actif')->boolean(),
            ])
            ->defaultSort('year', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->options(PublicationType::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'edit' => Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}