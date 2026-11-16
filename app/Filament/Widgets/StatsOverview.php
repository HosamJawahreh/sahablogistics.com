<?php

namespace App\Filament\Widgets;

use App\Models\ContactInquiry;
use App\Models\Language;
use App\Models\PageSection;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('New enquiries', ContactInquiry::query()->where('status', 'new')->count()),
            Stat::make('Active languages', Language::query()->where('is_active', true)->count()),
            Stat::make('Published sections', PageSection::query()->where('is_enabled', true)->where('is_published', true)->count()),
        ];
    }
}
