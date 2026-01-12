<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Log;
use PHPUnit\Metadata\After;

class TestStateWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        Log::info(User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')->whereYear('created_at', now()->year)->groupBy('month')->orderBy('month')->pluck('count')->toArray());
        return [
            //
            Stat::make("Total Users", User::count())
                ->description("Total number of users")
                ->descriptionIcon(Heroicon::ArrowDownCircle)
                ->chart(User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')->whereYear('created_at', now()->year)->groupBy('month')->orderBy('month')->pluck('count')->toArray())
                ->color('success'),

            Stat::make("Total Posts", Post::count())
                ->description("Total number of Posts")
                ->descriptionIcon(Heroicon::ArrowDownCircle)
                ->chart(Post::selectRaw('MONTH(created_at) as month, COUNT(*) as count')->whereYear('created_at', now()->year)->groupBy('month')->orderBy('month')->pluck('count')->toArray())
                ->color('info'),

            Stat::make("Total Category", Category::count())
                ->description("Total number of Category")
                ->descriptionIcon(Heroicon::ArrowDownCircle)
                ->chart(Category::selectRaw('MONTH(created_at) as month, COUNT(*) as count')->whereYear('created_at', now()->year)->groupBy('month')->orderBy('month')->pluck('count')->toArray())
                ->color('primary')
        ];
    }
}


