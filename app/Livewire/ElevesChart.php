<?php

namespace App\Livewire;

use App\Models\Eleve;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ElevesChart extends ChartWidget
{
    protected static ?string $heading = 'Graphe des parents d\'élèves';
    protected static string $color = 'info';


    protected function getData(): array
    {
        // Récupérer les professions des parents et le nombre d'occurrences pour chaque profession
        $professionStats = Eleve::selectRaw('profespar, COUNT(*) as total')
            ->groupBy('profespar')
            ->havingRaw('COUNT(*) > ?', [10])
            //->orderBy('total', 'desc') // Trier par le total en ordre décroissant
            //->limit(10) // Limiter aux 10 premiers résultats
            ->get();

        // Extraire les labels (professions) et les données (nombre de chaque profession)
        $labels = $professionStats->pluck('profespar')->toArray();
        $data = $professionStats->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Profession des parents d\'élèves',
                    'data' => $data, // Les nombres de chaque profession
                    'backgroundColor' => '#42a5f5', // Tu peux personnaliser la couleur ici
                ],
            ],
            'labels' => $labels, // Les professions des parents
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
