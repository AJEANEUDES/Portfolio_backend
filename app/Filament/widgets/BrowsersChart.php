<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\ChartWidget;

class BrowsersChart extends ChartWidget
{
    protected static ?string $heading = 'Navigateurs (30 jours)';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $browsers = PageView::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('browser, COUNT(*) as count')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'browser');

        return [
            'datasets' => [
                [
                    'data' => $browsers->values()->toArray(),
                    'backgroundColor' => ['#2563eb', '#059669', '#d97706', '#dc2626', '#7c3aed'],
                ],
            ],
            'labels' => $browsers->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}