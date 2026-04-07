<?php

namespace App\Filament\Resources;

use App\Enums\ProjectCategory;
use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    use Translatable;

    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 30;
    protected static ?string $modelLabel = 'Projet';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informations principales')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nom du projet')
                    ->required(),
                Forms\Components\Select::make('category')
                    ->label('Catégorie')
                    ->options(ProjectCategory::class)
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Description courte')
                    ->required()
                    ->maxLength(500)
                    ->rows(3),
                Forms\Components\RichEditor::make('long_description')
                    ->label('Description détaillée')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('screenshot')
                    ->label('Screenshot')
                    ->image()
                    ->directory('projects/screenshots')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1280')
                    ->imageResizeTargetHeight('720'),
                Forms\Components\DatePicker::make('date')
                    ->label('Date de réalisation'),
            ])->columns(2),

            Forms\Components\Section::make('Traductions')->schema([
                Forms\Components\TextInput::make('name_translatable')
                    ->label('Nom (traduit)'),
                Forms\Components\Textarea::make('description_translatable')
                    ->label('Description courte (traduite)')
                    ->rows(3),
                Forms\Components\RichEditor::make('long_description_translatable')
                    ->label('Description détaillée (traduite)'),
            ])->columns(1)->collapsible(),

            Forms\Components\Section::make('Liens du projet')->schema([
                Forms\Components\TextInput::make('website_url')
                    ->label('Site web')
                    ->url()
                    ->placeholder('https://...'),
                Forms\Components\TextInput::make('github_url')
                    ->label('GitHub')
                    ->url()
                    ->placeholder('https://github.com/...'),
                Forms\Components\TextInput::make('mobile_url')
                    ->label('App mobile (Play Store / App Store)')
                    ->url(),
                Forms\Components\TextInput::make('demo_url')
                    ->label('Lien démo')
                    ->url(),
            ])->columns(2),

            Forms\Components\Section::make('Vidéo de présentation')
                ->description('La vidéo permet aux recruteurs de découvrir ton projet rapidement sans consulter le code source.')
                ->schema([
                Forms\Components\TextInput::make('video_url')
                    ->label('URL de la vidéo')
                    ->url()
                    ->placeholder('https://youtube.com/watch?v=... ou https://vimeo.com/...')
                    ->helperText('YouTube, Vimeo ou lien direct vers une vidéo MP4'),
                Forms\Components\FileUpload::make('video_thumbnail')
                    ->label('Miniature vidéo (optionnel)')
                    ->image()
                    ->directory('projects/thumbnails')
                    ->helperText('Si vide, la miniature sera extraite automatiquement du lien YouTube/Vimeo'),
            ])->columns(1),

            Forms\Components\Section::make('Technologies & Paramètres')->schema([
                Forms\Components\Select::make('technologies')
                    ->label('Technologies utilisées')
                    ->relationship('technologies', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('tags')
                    ->label('Tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required(),
                    ]),
                Forms\Components\Toggle::make('is_featured')
                    ->label('Projet mis en avant'),
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
                Tables\Columns\ImageColumn::make('screenshot')->label('Aperçu')->square(),
                Tables\Columns\TextColumn::make('name')->label('Projet')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category')->label('Catégorie')->badge(),
                Tables\Columns\TextColumn::make('technologies.name')->label('Technologies')->badge()->limitList(3),
                Tables\Columns\IconColumn::make('video_url')
                    ->label('Vidéo')
                    ->boolean()
                    ->getStateUsing(fn ($record) => !empty($record->video_url)),
                Tables\Columns\IconColumn::make('is_featured')->label('Vedette')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Actif')->boolean(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Catégorie')
                    ->options(ProjectCategory::class),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Mis en avant'),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}