<?php

namespace App\Filament\Widgets;
use App\Models\User;

use Filament\Widgets\ChartWidget;

class UserChart extends ChartWidget
{
    protected ?string $heading = 'User Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')->whereYear('created_at', now()->year)->groupBy('month')->orderBy('month')->pluck('count')->toArray(),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
