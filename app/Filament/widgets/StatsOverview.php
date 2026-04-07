<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\PageView;
use App\Models\Post;
use App\Models\Project;
use App\Models\Publication;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $todayViews = PageView::today()->count();
        $monthViews = PageView::thisMonth()->count();
        $totalViews = PageView::count();

        // Calcul tendance (comparaison avec le mois précédent)
        $lastMonthViews = PageView::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $viewsTrend = $lastMonthViews > 0
            ? round((($monthViews - $lastMonthViews) / $lastMonthViews) * 100, 1)
            : 0;

        return [
            Stat::make('Visites aujourd\'hui', number_format($todayViews))
                ->description('Visiteurs uniques')
                ->descriptionIcon('heroicon-o-eye')
                ->color('primary'),

            Stat::make('Visites ce mois', number_format($monthViews))
                ->description($viewsTrend >= 0 ? "+{$viewsTrend}% vs mois dernier" : "{$viewsTrend}% vs mois dernier")
                ->descriptionIcon($viewsTrend >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down')
                ->color($viewsTrend >= 0 ? 'success' : 'danger'),

            Stat::make('Total visites', number_format($totalViews))
                ->description('Depuis le lancement')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('info'),

            Stat::make('Projets', Project::where('is_active', true)->count())
                ->description(Project::where('is_featured', true)->count() . ' mis en avant')
                ->descriptionIcon('heroicon-o-rectangle-stack')
                ->color('warning'),

            Stat::make('Articles publiés', Post::published()->count())
                ->description(Post::draft()->count() . ' brouillons')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('success'),

            Stat::make('Messages non lus', ContactMessage::unread()->count())
                ->description(ContactMessage::count() . ' total')
                ->descriptionIcon('heroicon-o-envelope')
                ->color(ContactMessage::unread()->count() > 0 ? 'danger' : 'gray'),
        ];
    }
}