<?php

namespace App\Filament\Resources;

use App\Enums\LetterStatus;
use App\Filament\Resources\ReferenceResource\Pages;
use App\Models\Reference;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReferenceResource extends Resource
{
    protected static ?string $model = Reference::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 47;
    protected static ?string $modelLabel = 'Référence';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Identité du référent')
                ->description('Informations sur la personne qui vous recommande.')
                ->schema([
                    Forms\Components\TextInput::make('full_name')
                        ->label('Nom complet')
                        ->required()
                        ->placeholder('Prof. Bruno Bouchard'),
                    Forms\Components\TextInput::make('title')
                        ->label('Titre / Poste')
                        ->required()
                        ->placeholder('Professeur titulaire'),
                    Forms\Components\TextInput::make('organization')
                        ->label('Organisation')
                        ->required()
                        ->placeholder('Université du Québec à Chicoutimi'),
                    Forms\Components\TextInput::make('department')
                        ->label('Département')
                        ->placeholder('Département d\'informatique et de mathématique'),
                    Forms\Components\FileUpload::make('photo')
                        ->label('Photo')
                        ->image()
                        ->directory('references/photos')
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('1:1')
                        ->imageResizeTargetWidth('300')
                        ->imageResizeTargetHeight('300'),
                    Forms\Components\FileUpload::make('organization_logo')
                        ->label('Logo organisation')
                        ->image()
                        ->directory('references/logos'),
                ])->columns(2),

            Forms\Components\Section::make('Relation professionnelle')
                ->schema([
                    Forms\Components\TextInput::make('relationship')
                        ->label('Relation avec vous')
                        ->required()
                        ->placeholder('Directeur de recherche — Projet LADDER'),
                    Forms\Components\TextInput::make('relationship_period')
                        ->label('Période')
                        ->placeholder('Janvier 2024 — Présent'),
                    Forms\Components\Textarea::make('testimonial')
                        ->label('Témoignage / Citation')
                        ->rows(4)
                        ->placeholder('« Jean a démontré une capacité exceptionnelle... »')
                        ->helperText('Citation courte que le référent vous autorise à publier. Laisser vide si pas de citation.')
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Lettre de recommandation')
                ->schema([
                    Forms\Components\Select::make('letter_status')
                        ->label('Statut de la lettre')
                        ->options(LetterStatus::class)
                        ->default('on_request')
                        ->required(),
                    Forms\Components\FileUpload::make('letter_file')
                        ->label('Lettre (PDF)')
                        ->acceptedFileTypes(['application/pdf'])
                        ->directory('references/letters')
                        ->helperText('Upload uniquement si le référent vous a autorisé à la partager publiquement.'),
                ])->columns(2),

            Forms\Components\Section::make('Coordonnées du référent')
                ->description('Les coordonnées ne seront affichées sur le site que si vous activez l\'option ci-dessous.')
                ->schema([
                    Forms\Components\Toggle::make('show_contact_info')
                        ->label('Afficher les coordonnées sur le site')
                        ->helperText('Si désactivé, les coordonnées sont stockées mais pas visibles publiquement. Le recruteur devra vous les demander.')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->placeholder('bruno.bouchard@uqac.ca'),
                    Forms\Components\TextInput::make('phone')
                        ->label('Téléphone')
                        ->tel()
                        ->placeholder('+1 418 545-5011'),
                    Forms\Components\TextInput::make('linkedin_url')
                        ->label('LinkedIn')
                        ->url()
                        ->placeholder('https://linkedin.com/in/...'),
                    Forms\Components\TextInput::make('website_url')
                        ->label('Site web')
                        ->url()
                        ->placeholder('https://...'),
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
                                    Forms\Components\TextInput::make('organization_translatable.en')
                                        ->label('Organisation (EN)'),
                                    Forms\Components\TextInput::make('department_translatable.en')
                                        ->label('Département (EN)'),
                                    Forms\Components\TextInput::make('relationship_translatable.en')
                                        ->label('Relation (EN)'),
                                    Forms\Components\Textarea::make('testimonial_translatable.en')
                                        ->label('Témoignage (EN)')
                                        ->rows(3),
                                ]),
                            Forms\Components\Tabs\Tab::make('Espagnol')
                                ->schema([
                                    Forms\Components\TextInput::make('title_translatable.es')
                                        ->label('Titre (ES)'),
                                    Forms\Components\TextInput::make('organization_translatable.es')
                                        ->label('Organisation (ES)'),
                                    Forms\Components\TextInput::make('relationship_translatable.es')
                                        ->label('Relation (ES)'),
                                    Forms\Components\Textarea::make('testimonial_translatable.es')
                                        ->label('Témoignage (ES)')
                                        ->rows(3),
                                ]),
                        ]),
                ]),

            Forms\Components\Section::make('Paramètres')
                ->schema([
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
                Tables\Columns\ImageColumn::make('photo')
                    ->label('')
                    ->circular(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->limit(30),
                Tables\Columns\TextColumn::make('organization')
                    ->label('Organisation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('relationship')
                    ->label('Relation')
                    ->limit(30),
                Tables\Columns\TextColumn::make('letter_status')
                    ->label('Lettre')
                    ->badge(),
                Tables\Columns\IconColumn::make('show_contact_info')
                    ->label('Contact visible')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Ordre')
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('letter_status')
                    ->label('Statut lettre')
                    ->options(LetterStatus::class),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Actif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReferences::route('/'),
            'create' => Pages\CreateReference::route('/create'),
            'edit' => Pages\EditReference::route('/{record}/edit'),
        ];
    }
}