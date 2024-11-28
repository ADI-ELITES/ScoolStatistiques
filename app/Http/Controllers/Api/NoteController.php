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

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune note trouvée pour ces critères.',
            ], 404);
        }

        return response()->json(
            $note
        );
    }

    public function saveEleveNoteInMatiere(Request $request)
    {
        // Validation des données
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

        try {
            // Supprimer la note existante avec les mêmes clés, si elle existe
            Note::where([
                'niveau' => $attrs['niveau'],
                'serie' => $attrs['serie'],
                'codeclas' => $attrs['codeclas'],
                'matric' => $attrs['matric'],
                'periode' => $attrs['periode'],
                'matiere' => $attrs['matiere'],
            ])->delete();

            // Créer une nouvelle note
            $note = Note::create([
                'niveau' => $attrs['niveau'],
                'serie' => $attrs['serie'],
                'codeclas' => $attrs['codeclas'],
                'matric' => $attrs['matric'],
                'periode' => $attrs['periode'],
                'matiere' => $attrs['matiere'],
                'devoir01' => (float) $attrs['devoir01'],
                'devoir02' => (float) $attrs['devoir02'],
                'devoir03' => (float) $attrs['devoir03'],
                'compos' => (float) $attrs['compos'],
            ]);

            return response()->json($note, 201);
        } catch (\Exception $e) {
            // Gérer les erreurs et retourner une réponse utile
            return response()->json([
                'error' => 'Une erreur est survenue lors de l\'enregistrement de la note.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }


}
