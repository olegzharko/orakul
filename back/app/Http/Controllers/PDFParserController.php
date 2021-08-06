<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PDFParserController extends Controller
{
    public function start()
    {
        $parser = new \Smalot\PdfParser\Parser();
        dd($parser);
        $pdf    = $parser->parseFile('document.pdf');

        $text = $pdf->getText();
        echo $text;
    }
}
