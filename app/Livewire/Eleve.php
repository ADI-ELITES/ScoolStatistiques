<?php

namespace App\Livewire;

use App\Models\Eleve as EleveModel;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;

class Eleve extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(EleveModel::query())
            ->columns([
                TextColumn::make('nom'),
                TextColumn::make('prenom'),
                TextColumn::make('sexe'),
                TextColumn::make('datenais'),
                TextColumn::make('phoneeleve'),
                TextColumn::make('nompar'),
                TextColumn::make('prenpar'),
                TextColumn::make('sexepar'),
                TextColumn::make('profespar'),
                TextColumn::make('phonepar'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    #[Layout('layouts.guest')]
    public function render(): View
    {
        return view('livewire.eleve');
    }
}
