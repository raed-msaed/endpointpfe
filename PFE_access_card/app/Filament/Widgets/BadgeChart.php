<?php

namespace App\Filament\Widgets;

use App\Models\Badget;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class BadgeChart extends ChartWidget
{
    protected static ?string $heading = 'عدد البطاقات الموزعة حسب الشهر';

    protected static ?int $sort = 2;
    protected function getData(): array
    {
        $data = Trend::model(Badget::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'عدد البطاقات',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}