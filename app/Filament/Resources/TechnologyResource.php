<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TechnologyResource\Pages;
use App\Models\Technology;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Concerns\Translatable;


class TechnologyResource extends Resource
{
    use Translatable;
    
    protected static ?string $model = Technology::class;
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 90;
    protected static ?string $modelLabel = 'Technologie';
    protected static ?string $pluralModelLabel = 'Technologies';

    public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\Section::make()->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nom')
                ->required()
                ->maxLength(100)
                ->live(onBlur: true),
            Forms\Components\TextInput::make('slug')
                ->label('Slug')
                ->disabled()
                ->dehydrated(true),
            Forms\Components\TextInput::make('description')
                ->label('Description courte')
                ->placeholder('Ex: Framework PHP, Langage polyvalent...')
                ->helperText('Affichée dans le carousel du Hero')
                ->maxLength(100)
                ->columnSpanFull(),
            Forms\Components\FileUpload::make('icon')
                ->label('Icône')
                ->image()
                ->directory('technologies')
                ->acceptedFileTypes(['image/svg+xml', 'image/png', 'image/webp']),
            Forms\Components\TextInput::make('order')
                ->label('Ordre')
                ->numeric()
                ->default(0),
            Forms\Components\Toggle::make('is_active')
                ->label('Active')
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
                                Forms\Components\TextInput::make('description_translatable.en')
                                    ->label('Description (EN)'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Espagnol')
                            ->schema([
                                Forms\Components\TextInput::make('description_translatable.es')
                                    ->label('Description (ES)'),
                            ]),
                    ]),
            ]),
    ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('icon')->label('Icône')->circular(),
                Tables\Columns\TextColumn::make('name')->label('Nom')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
                Tables\Columns\TextColumn::make('order')->label('Ordre')->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTechnologies::route('/'),
            'create' => Pages\CreateTechnology::route('/create'),
            'edit' => Pages\EditTechnology::route('/{record}/edit'),
        ];
    }
}