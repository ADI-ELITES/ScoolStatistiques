<?php

use Livewire\Volt\Component;

use App\Models\Eleve as EleveModel;
use Livewire\Attributes\{Layout, Title};
use Illuminate\Validation\Rule;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

new
#[Layout('layouts.app')]
#[Title('Elèves')]
class extends Component implements HasForms, HasTable {
    use InteractsWithForms;
    use InteractsWithTable;

    public $matric = '', $nom = '', $prenom = '', $sexe = '', $datenais ='', $phoneeleve ='', $nompar = '', $prenpar = '', $profespar ='', $phonepar = '';

    public function rules()
    {
        return [
            'matric' => 'required|max:14',
            'nom' => 'required|max:25',
            'prenom' => 'required|max:25',
            'sexe' => 'required|max:1',
            'datenais' => 'required|date',
            'phoneeleve' => 'required|max:15',
            'nompar' => 'required|max:25',
            'prenpar' => 'required|max:25',
            'profespar' => 'required|max:20',
            'phonepar' => 'required|max:15',
        ];
    }

    public function save ()
    {
        // Validation des données du formulaire
        $validateData = $this->validate();
        EleveModel::create($validateData);
        return $this->redirect('/eleves');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(EleveModel::query())
            ->columns([
                TextColumn::make('matric')->searchable(),
                TextColumn::make('nom')->sortable(),
                TextColumn::make('prenom'),
                TextColumn::make('sexe'),
                TextColumn::make('datenais')->sortable(),
                TextColumn::make('phoneeleve'),
                TextColumn::make('nompar')->searchable(),
                TextColumn::make('prenpar'),
                TextColumn::make('profespar'),
                TextColumn::make('phonepar'),
            ])
            ->filters([
                SelectFilter::make('sexe')
                    ->options([
                    'M' => 'Masculin',
                    'F' => 'Féminin',
                    ]),
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}; ?>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Liste des Elèves') }}
    </h2>
</x-slot>
<div class="py-12" x-data="{ showModal: false }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <button type="button"
                    @click="showModal = true"
                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    Créer un élève
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="shrink-0 size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>
                <div class="my-4">
                </div>
                {{ $this->table }}
            </div>
        </div>
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-50" @click="showModal = false"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full bg-gray-400 items-end justify-center p-4 sm:items-center sm:p-0">
                    <form wire:submit="save">
                        <div>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label for="matric" class="block text-sm font-bold">Matricule</label>
                                    <input type="text" wire:model='matric' class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('matric') <span class="text-red-700 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="nom" class="block text-sm font-bold">Nom</label>
                                    <input type="text" wire:model='nom' class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('nom') <span class="text-red-700 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="prenom" class="block text-sm font-bold">Prénom</label>
                                    <input type="text" wire:model="prenom" class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('prenom') <span class="text-red-700 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="sexe" class="block text-sm font-bold">Sexe</label>

                                    <select id="sexe" wire:model="sexe" name="sexe" class="rounded-lg border border-gray-300 mt-1 w-full">
                                        <option value=""></option>
                                        <option value="M">Masculin</option>
                                        <option value="F">Féminin</option>
                                    </select>
                                    <div>
                                        @error('sexe') <span class="text-red-700">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="datenais" class="block text-sm font-bold">Date de naissance</label>
                                    <input type="date" wire:model="datenais" class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('datenais') <span class="text-red-700 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="phoneeleve" class="block text-sm font-bold">Téléphone de l'élève</label>
                                    <input type="text" wire:model="phoneeleve"
                                        class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('phoneeleve') <span class="text-red-700 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="nompar" class="block text-sm font-bold">Nom du parent</label>
                                    <input type="text" wire:model="nompar" class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('nompar') <span class="text-red-700 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="prenpar" class="block text-sm font-bold">Prénom du parent</label>
                                    <input type="text" wire:model="prenpar" class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('prenpar') <span class="text-red-700 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="profespar" class="block text-sm font-bold">Profession du parent</label>
                                    <input type="text" wire:model="profespar" class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('profespar') <span class="text-red-700 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="phonepar" class="block text-sm font-bold">Contact du parent</label>
                                    <input type="text" wire:model="phonepar" class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('phonepar') <span class="text-red-700 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-2">
                            <button type="submit"
                                class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                Enregistrer
                            </button>
                            <button type="button"
                                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                                @click="showModal = false">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
