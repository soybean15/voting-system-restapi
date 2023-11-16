<?php


namespace App\Http\Services;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class DomPDFService{


    protected static $pdf;

    public static function generate( String $view,array $data){

        self::$pdf = PDF::loadView($view, ['data' => $data]);

        return new self();

        
    }


    public function stream() {
        
       // Load the data into a view
       
       // Generate the PDF
        return self::$pdf->stream();


    }    




    public function download() {

        // Generate the PDF
       return self::$pdf->download();

        // Set the response headers for PDF download

    }
}