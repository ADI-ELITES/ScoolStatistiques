<?php

namespace App\Livewire;

use App\Models\Eleve;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EleveOverView extends BaseWidget
{
    //protected $profession_parents = Eleve::distinct('profespar');

    protected function getStats(): array
    {
        // Récupérer les professions des parents et le nombre d'occurrences pour chaque profession
        $professionStats = Eleve::selectRaw('profespar, COUNT(*) as total')
            ->groupBy('profespar')
            ->get();

        // Créer un tableau pour stocker les stats des professions
        $professionStatsArray = [];
        foreach ($professionStats as $profession) {
            $professionStatsArray[] = Stat::make($profession->profespar, $profession->total)
                ->description("Nombre de parents avec la profession {$profession->profespar}")
                ->color('primary'); // Tu peux personnaliser la couleur selon tes besoins
        }

        return $professionStatsArray;
    }
}
