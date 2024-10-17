<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use Illuminate\Http\Request;
use function Spatie\LaravelPdf\Support\pdf;
use Spatie\LaravelPdf\Facades\Pdf;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;


class EleveController extends Controller
{

    public function __construct()
    {

    }

    /**
     * Display a listing of the eleves.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all upcoming eleves with pagination
        $students = Eleve::paginate(10);
        return response()->json($students);
    }

    /**
     * Display the specified eleve.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the eleve by ID
        $eleve = Eleve::findOrFail($id);
        return response()->json($eleve);
    }

    public function generateBul($id)
    {
        //  Géneration de buletin à partir de l'élève
        set_time_limit(120); // Par exemple, pour 2 minutes
        $eleve = Eleve::findOrFail($id);

        Pdf::view('pdfs.pdf', ['eleve' => $eleve])
            ->save('pdfs/' . $eleve->nom . '_generate.pdf');

        // Définir le chemin de sauvegarde
        // $filePath = public_path('pdfs/' . $eleve->nom . '_generate.pdf');

        // // Générer et sauvegarder le PDF
        // pdf()
        //     ->view('pdf', compact('eleve'))
        //     ->name($eleve->nom . '_generate.pdf')
        //     ->save($filePath);

        // // Retourner l'URL de téléchargement
        $url = url('pdfs/' . $eleve->nom . '_generate.pdf');
        return response()->json([$url]);
    }

    public function exportStudentToPdf()
    {
        set_time_limit(120);

        $students = Eleve::limit(10)->get();
        $pdf = DomPDF::loadView('pdfs.export', ['students' => $students]);
        return $pdf->download('list_student.pdf');
        //return pdf('pdfs.export', ['students' => $students])->download('list_students.pdf');
        //return redirect()->back();
    }

    public function generateApi($id)
    {
        return redirect()->route('generate-bulettin', ['id' => $id]);
    }
}
