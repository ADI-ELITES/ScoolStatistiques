<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::all();
        return response()->json($notes);
    }

    public function getNoteByEleveMatiere(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'niveau' => 'required',
            'serie' => 'required',
            'codeclas' => 'required',
            'matric' => 'required',
            'matiere' => 'required',
        ]);

        $note = Note::where('niveau', $attrs['niveau'])
            ->where('serie', $attrs['serie'])
            ->where('codeclas', $attrs['codeclas'])
            ->where('matric', $attrs['matric'])
            ->where('matiere', $attrs['matiere'])
            ->first();

        return response()->json(
            $note
        );
    }

    public function saveEleveNoteInMatiere(Request $request)
    {
        // Valider les champs de la requête
        $attrs = $request->validate([
            'niveau' => 'required',
            'serie' => 'required',
            'codeclas' => 'required',
            'matric' => 'required',
            'periode' => 'required',
            'matiere' => 'required',
            'devoir01' => 'required|numeric|between:0,20',
            'devoir02' => 'required|numeric|between:0,20',
            'devoir03' => 'required|numeric|between:0,20',
            'compos' => 'required|numeric|between:0,20',
        ]);

        // Compléter le nom de la matière à 20 caractères si nécessaire
        $matiere = str_pad($attrs['matiere'], 20, ' ');

        // Vérifier et ajuster la série (si nécessaire)
        $serie = $attrs['serie'] === "CEG" ? $attrs['serie'] . ' ' : $attrs['serie'];

        // Utiliser updateOrCreate pour mettre à jour ou créer une note
        $note = Note::updateOrCreate(
            [
                'niveau' => $attrs['niveau'],
                'serie' => $serie,
                'codeclas' => $attrs['codeclas'],
                'matric' => $attrs['matric'],
                'periode' => $attrs['periode'],
                'matiere' => $matiere,
            ],
            [
                'devoir01' => (float) $attrs['devoir01'],
                'devoir02' => (float) $attrs['devoir02'],
                'devoir03' => (float) $attrs['devoir03'],
                'compos' => (float) $attrs['compos'],
            ]
        );

        return response()->json($note, 201);
    }
}
