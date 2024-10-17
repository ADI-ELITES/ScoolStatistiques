<!doctype html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries">
    </script>
</head>

<body>
    <div class="py-12 px-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="nom" class="block text-sm font-bold">Nom</label>
                            <input type="text" id="nom" name="nom" value="{{ $eleve->nom }}" disabled
                                class="rounded-lg border border-gray-300 mt-1 block w-full" />
                        </div>
                        <div>
                            <label for="prenom" class="block text-sm font-bold">Prénom</label>
                            <input type="text" id="prenom" name="prenom" value="{{ $eleve->prenom }}" disabled
                                class="rounded-lg border border-gray-300 mt-1 block w-full" />
                        </div>
                        <div>
                            <label for="sexe" class="block text-sm font-bold">Sexe</label>
                            <input type="text" id="sexe" name="sexe" value="{{ $eleve->sexe }}" disabled
                                class="rounded-lg border border-gray-300 mt-1 block w-full" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
