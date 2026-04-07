<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\ChartWidget;

class DevicesChart extends ChartWidget
{
    protected static ?string $heading = 'Appareils (30 jours)';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $devices = PageView::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('device_type, COUNT(*) as count')
            ->groupBy('device_type')
            ->pluck('count', 'device_type');

        return [
            'datasets' => [
                [
                    'data' => [
                        $devices->get('desktop', 0),
                        $devices->get('mobile', 0),
                        $devices->get('tablet', 0),
                        $devices->get('unknown', 0),
                    ],
                    'backgroundColor' => ['#2563eb', '#059669', '#d97706', '#6b7280'],
                ],
            ],
            'labels' => ['Desktop', 'Mobile', 'Tablette', 'Autre'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}