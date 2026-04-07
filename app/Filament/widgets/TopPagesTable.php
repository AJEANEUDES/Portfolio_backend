<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopPagesTable extends BaseWidget
{
    protected static ?string $heading = 'Pages les plus visitées (30 jours)';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PageView::query()
                    ->where('created_at', '>=', now()->subDays(30))
                    ->selectRaw('url, COUNT(*) as visits, COUNT(DISTINCT browser) as unique_visits')
                    ->groupBy('url')
                    ->orderByDesc('visits')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('url')
                    ->label('Page')
                    ->searchable(),
                Tables\Columns\TextColumn::make('visits')
                    ->label('Visites')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('unique_visits')
                    ->label('Visiteurs uniques')
                    ->sortable()
                    ->badge()
                    ->color('success'),
            ])
            ->paginated(false);
    }
}