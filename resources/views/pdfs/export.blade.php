<!doctype html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>

    <style>
        tr:nth-child(even) {
            background-color: #dddddd;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>

<body>
    <div class="p-4 text-gray-900 dark:text-gray-100">
        <h1>Listes des élèves</h1>
        <table class="border border-solid">
            <thead>
                <tr class="border">
                    <th class="border border-solid">Matricule</th>
                    <th class="border border-solid">Nom</th>
                    <th class="border border-solid">Prénom</th>
                    <th class="border border-solid">Sexe</th>
                    <th class="border border-solid">DateNais</th>
                    <th class="border border-solid">PhoneEleve</th>
                    <th class="border border-solid">NomParent</th>
                    <th class="border border-solid">PrénParent</th>
                    <th class="border border-solid">SexePar</th>
                    <th class="border border-solid">ProfesParent</th>
                    <th class="border border-solid">PhonePar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $eleve)
                <tr class="border">
                    <td>{{ $eleve->matric }}</td>
                    <td>{{ $eleve->nom }}</td>
                    <td>{{ $eleve->prenom }}</td>
                    <td>{{ $eleve->sexe }}</td>
                    <td>{{ $eleve->datenais }}</td>
                    <td>{{ $eleve->phoneeleve }}</td>
                    <td>{{ $eleve->nompar }}</td>
                    <td>{{ $eleve->prenpar }}</td>
                    <td>{{ $eleve->sexepar }}</td>
                    <td>{{ $eleve->profespar }}</td>
                    <td>{{ $eleve->phonepar }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
