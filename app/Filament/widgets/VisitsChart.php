<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class VisitsChart extends ChartWidget
{
    protected static ?string $heading = 'Visites — 30 derniers jours';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $days = collect(range(29, 0))->map(function ($daysAgo) {
            return Carbon::now()->subDays($daysAgo)->format('Y-m-d');
        });

        $views = PageView::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        return [
            'datasets' => [
                [
                    'label' => 'Visites',
                    'data' => $days->map(fn ($date) => $views->get($date, 0))->toArray(),
                    'borderColor' => '#2563eb',
                    'backgroundColor' => 'rgba(37, 99, 235, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $days->map(fn ($date) => Carbon::parse($date)->format('d/m'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}