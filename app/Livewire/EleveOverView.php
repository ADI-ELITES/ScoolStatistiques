<?php

namespace App\Livewire;

use App\Models\Eleve;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EleveOverView extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Hommes', Eleve::where('sexe', 'M')->count())
                ->description('Nombre d\'hommes en base')
                ->chart([Eleve::where('sexe', 'M')->count()])
                ->extraAttributes(['class' => 'text-blue-500 bg-blue-200']),
            Stat::make('Total Femmes', Eleve::where('sexe', 'F')->count())
                ->description('Nombre de femmes en base')
                //->descriptionIcon('heroicon-m-arrow-trending-down')
                //->chart([17, 4, 15, 3, 10, 2, 7])
                ,
            Stat::make('Total élèves', Eleve::all()->count())
                ->description('Total des élèves'),
                //->descriptionIcon('heroicon-m-arrow-trending-up')
                //->color('success'),
        ];
    }
}
