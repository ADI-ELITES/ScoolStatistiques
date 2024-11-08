<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Matiere;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    public function index () {
        $matieres = Matiere::all();
        return response()->json($matieres);
    }

    
    public function getClassesMatieres(Request $request)
    {
        // Vérifiez le contenu brut de la chaîne JSON
        $classeJson = $request->input('classe');
        // Ajouter des guillemets autour des clés et valeurs manquants
        $classeJson = preg_replace('/(\w+):\s*([^,{]+?)\s*(?=,|$)/', '"$1": "$2"', $classeJson);

        // Supprimer les espaces en trop et s'assurer que les guillemets sont bien fermés
        $classeJson = trim($classeJson, ' ,');

        // Vérifiez le résultat après décodage
        dd($classeJson); // Cela doit afficher un tableau PHP contenant les données de la classe
        // Utiliser les attributs de $classe pour récupérer les matières correspondantes
        $matieres = Matiere::where('niveau', '=', $request->classe->niveau)
            // ->where('serie', '=', 'CEG ')
            // ->where('codeclas', '=', $classe->codeclas)
            ->get();

        // Retourner les matières au format JSON
        return response()->json($matieres);
    }
}
