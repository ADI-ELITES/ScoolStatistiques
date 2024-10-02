<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="my-4">
                        <h2 class="font-semibold leading-6 my-2">Données statistique des parents</h2>
                        @livewire(\App\Livewire\EleveOverView::class)
                    </div>
                    <div class="my-4">
                        @livewire(\App\Livewire\ElevesChart::class)
                    </div>
                    {{-- <canvas id="myChart"></canvas> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
