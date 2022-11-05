<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use PDF;

class PdfController extends Controller
{
    public function index()
    {
        $pdf = PDF::loadView('anamnese', [
            'title' => 'CodeAndDeploy.com Laravel Pdf Tutorial',
            'description' => 'This is an example Laravel pdf tutorial.',
            'footer' => 'by <a href="https://codeanddeploy.com">codeanddeploy.com</a>'
        ]);

        Storage::put('public/tmp/pdf/anamnese.pdf', $pdf->output());

        return $pdf->download('anamnese.pdf');
    }
}
