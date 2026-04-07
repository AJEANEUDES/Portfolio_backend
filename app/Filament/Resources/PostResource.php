<?php

namespace App\Filament\Resources;

use App\Enums\PostStatus;
use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    use Translatable;

    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Blog';
    protected static ?int $navigationSort = 50;
    protected static ?string $modelLabel = 'Article';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Article')->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->live(onBlur: true),
                Forms\Components\Select::make('status')
                    ->label('Statut')
                    ->options(PostStatus::class)
                    ->default('draft')
                    ->required(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Date de publication'),
                Forms\Components\FileUpload::make('cover_image')
                    ->label('Image de couverture')
                    ->image()
                    ->directory('posts/covers')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1280')
                    ->imageResizeTargetHeight('720'),
                Forms\Components\Textarea::make('excerpt')
                    ->label('Extrait')
                    ->maxLength(300)
                    ->rows(2)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')
                    ->label('Contenu')
                    ->required()
                    ->columnSpanFull()
                    ->fileAttachmentsDirectory('posts/attachments'),
            ])->columns(2),

            Forms\Components\Section::make('Traductions')->schema([
                Forms\Components\TextInput::make('title_translatable')
                    ->label('Titre (traduit)'),
                Forms\Components\Textarea::make('excerpt_translatable')
                    ->label('Extrait (traduit)')
                    ->rows(2),
                Forms\Components\RichEditor::make('content_translatable')
                    ->label('Contenu (traduit)'),
            ])->columns(1)->collapsible(),

            Forms\Components\Section::make('Catégories & Tags')->schema([
                Forms\Components\Select::make('categories')
                    ->label('Catégories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\Hidden::make('type')->default('post'),
                    ]),
                Forms\Components\Select::make('tags')
                    ->label('Tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required(),
                    ]),
            ])->columns(2),

            Forms\Components\Section::make('SEO')->schema([
                Forms\Components\TextInput::make('seo_title')
                    ->label('Meta Title')
                    ->maxLength(70)
                    ->helperText('Laisser vide pour utiliser le titre de l\'article'),
                Forms\Components\Textarea::make('seo_description')
                    ->label('Meta Description')
                    ->maxLength(160)
                    ->rows(2),
            ])->columns(1)->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('')->square(),
                Tables\Columns\TextColumn::make('title')->label('Titre')->searchable()->sortable()->limit(50),
                Tables\Columns\TextColumn::make('status')->label('Statut')->badge(),
                Tables\Columns\TextColumn::make('categories.name')->label('Catégories')->badge(),
                Tables\Columns\TextColumn::make('reading_time')
                    ->label('Lecture')
                    ->suffix(' min')
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Non publié'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options(PostStatus::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}