<?php

use Livewire\Volt\Component;

use App\Models\Eleve as EleveModel;
use Livewire\Attributes\{Layout, Title};
use Filament\Tables;
use Illuminate\Validation\Rule;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;
use App\Exports\ElevesExport;
use Maatwebsite\Excel\Facades\Excel;

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
            'sexepar' => 'required|max:1',
            'profespar' => 'required|max:20',
            'phonepar' => 'required|max:15',
        ];
    }

    public function save ()
    {
        // Validation des données du formulaire
        $validateData = $this->validate();
        EleveModel::create($validateData);
        Notification::make()
            ->title('Création d\' élèves réussit.')
            ->success()
            ->send();
        return $this->redirect('/eleves');
    }

    public function exportToExcel ()
    {
        Notification::make()
            ->title('Succès de la génération en Excel')
            ->success()
            ->send();
        return Excel::download(new ElevesExport, 'students.xlsx');
    }

    public function exportToCsv ()
    {
        Notification::make()
            ->title('Succès de la génération en Csv')
            ->success()
            ->send();
        return Excel::download(new ElevesExport, 'students.csv', Maatwebsite\Excel\Excel::CSV);
    }

    public function exportToPdf ()
    {
        try {
            Notification::make()
                ->title('Veuillez patientez,')
                ->body('Le télechargement va bientôt commencé !')
                ->success()
                ->send();
            return redirect()->route('export-students');
        } catch (\Exception $e) {
            return redirect()->back()->with($e);
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(EleveModel::query())
            ->columns([
                TextColumn::make('matric')->searchable(),
                TextColumn::make('nom')->sortable(),
                TextColumn::make('prenom')->searchable(),
                TextColumn::make('sexe'),
                TextColumn::make('datenais')->sortable(),
                TextColumn::make('phoneeleve'),
                TextColumn::make('nompar')->searchable(),
                TextColumn::make('prenpar')->searchable(),
                TextColumn::make('sexepar'),
                TextColumn::make('profespar'),
                TextColumn::make('phonepar'),
            ])
            ->filters([
                SelectFilter::make('sexe')
                    ->options([
                    'M' => 'Masculin',
                    'F' => 'Féminin',
                    ]),
                SelectFilter::make('sexepar')
                    ->options([
                    'M' => 'Masculin',
                    'F' => 'Féminin',
                    ]),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    // ...
                ]),
            ])->headerActions([
                /*ExportAction::make()
                    ->exporter(EleveExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                        ExportFormat::Csv,
                    ])*/
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
                <div class="flex flex-row">
                    <div class="basis-1/5">
                        <button type="button" @click="showModal = true"
                            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Créer un élève
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="shrink-0 size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    </div>
                    <div class="basis-4/5 flex justify-end gap-4">
                        <button type="button" wire:click="exportToExcel"
                            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-slate-600 text-white hover:bg-slate-700 focus:outline-none focus:bg-slate-700 disabled:opacity-50 disabled:pointer-events-none">
                            Exporter en Excel
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-down shrink-0 size-5">
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M12 18v-6" />
                                <path d="m9 15 3 3 3-3" />
                            </svg>
                        </button>
                        <button type="button" wire:click="exportToCsv"
                            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-amber-600 text-white hover:bg-amber-700 focus:outline-none focus:bg-amber-700 disabled:opacity-50 disabled:pointer-events-none">
                            Exporter en CSV
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="shrink-0 size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </button>
                        <button type="button" wire:click="exportToPdf"
                            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 focus:outline-none focus:bg-green-700 disabled:opacity-50 disabled:pointer-events-none">
                            Exporter en PDF
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-down shrink-0 size-5">
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M12 18v-6" />
                                <path d="m9 15 3 3 3-3" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="my-4">
                </div>
                {{ $this->table }}
            </div>
        </div>
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-50" @click="showModal = false"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full bg-gray-100 items-end justify-center p-4 sm:items-center sm:p-0">
                    <form wire:submit="save">
                        <div>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label for="matric" class="block text-sm font-bold">Matricule</label>
                                    <input type="text" wire:model='matric'
                                        class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('matric') <span class="text-red-700 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="nom" class="block text-sm font-bold">Nom</label>
                                    <input type="text" wire:model='nom'
                                        class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('nom') <span class="text-red-700 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="prenom" class="block text-sm font-bold">Prénom</label>
                                    <input type="text" wire:model="prenom"
                                        class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('prenom') <span class="text-red-700 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="sexe" class="block text-sm font-bold">Sexe</label>
                                    <select id="sexe" wire:model="sexe" name="sexe"
                                        class="rounded-lg border border-gray-300 mt-1 w-full">
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
                                    <input type="date" wire:model="datenais"
                                        class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('datenais') <span class="text-red-700 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="phoneeleve" class="block text-sm font-bold">Téléphone de l'élève</label>
                                    <input type="text" wire:model="phoneeleve"
                                        class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('phoneeleve') <span class="text-red-700 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="nompar" class="block text-sm font-bold">Nom du parent</label>
                                    <input type="text" wire:model="nompar"
                                        class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('nompar') <span class="text-red-700 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="prenpar" class="block text-sm font-bold">Prénom du parent</label>
                                    <input type="text" wire:model="prenpar"
                                        class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('prenpar') <span class="text-red-700 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="sexepar" class="block text-sm font-bold">Sexe du parent</label>
                                    <select id="sexepar" wire:model="sexepar" name="sexepar"
                                        class="rounded-lg border border-gray-300 mt-1 w-full">
                                        <option value=""></option>
                                        <option value="M">Masculin</option>
                                        <option value="F">Féminin</option>
                                    </select>
                                    <div>
                                        @error('sexepar') <span class="text-red-700">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="profespar" class="block text-sm font-bold">Profession du parent</label>
                                    <input type="text" wire:model="profespar"
                                        class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('profespar') <span class="text-red-700 error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="phonepar" class="block text-sm font-bold">Contact du parent</label>
                                    <input type="text" wire:model="phonepar"
                                        class="rounded-lg border border-gray-300 mt-1 block w-full" />
                                    <div>
                                        @error('phonepar') <span class="text-red-700 error">{{ $message }}</span>
                                        @enderror
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
