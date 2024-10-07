<?php

namespace App\Filament\Exports;

use App\Models\Eleve;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EleveExporter extends Exporter
{
    protected static ?string $model = Eleve::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('matric'),
            ExportColumn::make('nom'),
            ExportColumn::make('prenom'),
            ExportColumn::make('sexe'),
            ExportColumn::make('datenais'),
            ExportColumn::make('phoneeleve'),
            ExportColumn::make('nompar'),
            ExportColumn::make('prenpar'),
            ExportColumn::make('profespar'),
            ExportColumn::make('phonepar'),
            ExportColumn::make('sexepar'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('deleted_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your eleve export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
