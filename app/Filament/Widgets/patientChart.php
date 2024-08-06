<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class patientChart extends ChartWidget
{

    protected static ?string $heading = 'Patients Overview';

    protected static ?string $maxHeight = '300px';

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => true,
                'position' => 'bottom',
            ],
        ],
    ];


    protected function getData(): array
    {
        $data = Patient::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get();

        $labels = $data->pluck('type')->toArray();
        $values = $data->pluck('total')->toArray();

        return [
            'labels' => $labels,
            'width' => 30,
            'datasets' => [
                [
                    'label' => 'Patients by Type',
                    'data' => $values,
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

}
