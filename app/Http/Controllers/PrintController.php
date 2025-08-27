<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Models\EventSessionParticipant;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class PrintController extends Controller
{
    public function index(Request $request)
    {
        switch($request->option){
            case 'session':
                return $this->print($request);
            break;
        }
    }

    public function print($request){
        $participant = $request->krdwrks;

        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($participant);

        $data = EventSessionParticipant::with('participant','session')->where('id',$id)->first();

        $url = $_SERVER['HTTP_HOST'].'/verification/'.$participant;
        $qrCode = new QrCode($url);
        $qrCode->setSize(300);
        $pngWriter = new PngWriter();
        $qrCodeImageString = $pngWriter->write($qrCode)->getString();
        $base64Image = 'data:image/png;base64,' . base64_encode($qrCodeImageString);
        
        $array = [
            'qrCodeImage' => $base64Image,
            'data' => $data
        ]; 

        $pdf = \PDF::loadView('reports.certificate',$array)->setPaper('a4', 'portrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $copies = 1;
            $totalPagesPerCopy = $pageCount / $copies;
            $currentPageInCopy = ($pageNumber - 1) % $totalPagesPerCopy + 1;
            $text = "PAGE $currentPageInCopy OF $totalPagesPerCopy";
            $font = $fontMetrics->get_font("Helvetica", "normal");
            $size = 7;
            $width = $fontMetrics->get_text_width($text, $font, $size);
            $canvas->text(106 - $width, 796, $text, $font, $size);
        });
        return $pdf->stream('certificate.pdf');
    }

}
