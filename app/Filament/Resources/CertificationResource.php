<?php

namespace App\Filament\Resources;

use App\Enums\CertificationCategory;
use App\Filament\Resources\CertificationResource\Pages;
use App\Models\Certification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CertificationResource extends Resource
{
    protected static ?string $model = Certification::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 48;
    protected static ?string $modelLabel = 'Certification';
    protected static ?string $pluralModelLabel = 'Certifications';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informations principales')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nom de la certification')
                        ->required()
                        ->placeholder('Ex: AWS Certified Solutions Architect - Associate'),
                    Forms\Components\TextInput::make('issuer')
                        ->label('Organisme émetteur')
                        ->required()
                        ->placeholder('Ex: Amazon Web Services'),
                    Forms\Components\Select::make('category')
                        ->label('Catégorie')
                        ->options(CertificationCategory::class)
                        ->required()
                        ->default('other'),
                    Forms\Components\FileUpload::make('issuer_logo')
                        ->label('Logo de l\'organisme')
                        ->disk('public')
                        ->directory('certifications/logos')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                        ->maxSize(2048),
                    Forms\Components\FileUpload::make('badge_image')
                        ->label('Image du badge')
                        ->disk('public')
                        ->directory('certifications/badges')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(2048),
                ])->columns(2),

            Forms\Components\Section::make('Identifiant & Vérification')
                ->schema([
                    Forms\Components\TextInput::make('credential_id')
                        ->label('ID de la certification')
                        ->placeholder('Ex: AWS-ASA-12345678'),
                    Forms\Components\TextInput::make('verification_url')
                        ->label('URL de vérification')
                        ->url()
                        ->placeholder('https://www.credly.com/badges/...'),
                ])->columns(2),

            Forms\Components\Section::make('Dates')
                ->schema([
                    Forms\Components\DatePicker::make('issued_date')
                        ->label('Date d\'obtention')
                        ->required()
                        ->native(false),
                    Forms\Components\DatePicker::make('expiration_date')
                        ->label('Date d\'expiration')
                        ->helperText('Laisser vide si la certification n\'expire pas')
                        ->native(false),
                ])->columns(2),

            Forms\Components\Section::make('Description & Compétences')
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->label('Description courte')
                        ->rows(3)
                        ->placeholder('Brève description de la certification et de ce qu\'elle valide.'),
                    Forms\Components\TagsInput::make('skills')
                        ->label('Compétences validées')
                        ->placeholder('Ajouter une compétence')
                        ->helperText('Appuyez sur Entrée après chaque compétence'),
                ])->columns(1),

            Forms\Components\Section::make('Traductions')
                ->collapsible()
                ->collapsed()
                ->schema([
                    Forms\Components\Tabs::make('translations')
                        ->tabs([
                            Forms\Components\Tabs\Tab::make('Anglais')
                                ->schema([
                                    Forms\Components\TextInput::make('name_translatable.en')
                                        ->label('Nom (EN)'),
                                    Forms\Components\Textarea::make('description_translatable.en')
                                        ->label('Description (EN)')
                                        ->rows(3),
                                ]),
                            Forms\Components\Tabs\Tab::make('Espagnol')
                                ->schema([
                                    Forms\Components\TextInput::make('name_translatable.es')
                                        ->label('Nom (ES)'),
                                    Forms\Components\Textarea::make('description_translatable.es')
                                        ->label('Description (ES)')
                                        ->rows(3),
                                ]),
                        ]),
                ]),

            Forms\Components\Section::make('Paramètres')
                ->schema([
                    Forms\Components\Toggle::make('is_featured')
                        ->label('Mise en avant')
                        ->helperText('Affiche un badge "Mis en avant" sur la carte'),
                    Forms\Components\TextInput::make('order')
                        ->label('Ordre d\'affichage')
                        ->numeric()
                        ->default(0),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('issuer_logo')
                    ->label('Logo')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('issuer')
                    ->label('Organisme')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Catégorie')
                    ->badge(),
                Tables\Columns\TextColumn::make('issued_date')
                    ->label('Obtenue le')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiration_date')
                    ->label('Expire le')
                    ->date('d M Y')
                    ->placeholder('Jamais')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Ordre')
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Catégorie')
                    ->options(CertificationCategory::class),
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Mise en avant'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertifications::route('/'),
            'create' => Pages\CreateCertification::route('/create'),
            'edit' => Pages\EditCertification::route('/{record}/edit'),
        ];
    }
}