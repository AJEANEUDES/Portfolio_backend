<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentMessages extends BaseWidget
{
    protected static ?string $heading = 'Messages récents';
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactMessage::query()
                    ->orderByDesc('created_at')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->label('')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope')
                    ->falseColor('warning'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom'),
                Tables\Columns\TextColumn::make('message')
                    ->label('Message')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reçu')
                    ->since(),
            ])
            ->paginated(false)
            ->actions([
                Tables\Actions\Action::make('read')
                    ->label('Lire')
                    ->icon('heroicon-o-eye')
                    ->url(fn (ContactMessage $record) => route('filament.admin.resources.contact-messages.view', $record)),
            ]);
    }
}