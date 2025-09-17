<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Models\EventSession;
use App\Models\EventSessionParticipant;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Mail\CertificateMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PrintController extends Controller
{
    public function index(Request $request)
    {   switch($request->option){
            case 'session':
                switch($request->type){
                    case 'appearance':
                        return $this->appearance($request);
                    break;
                    case 'appreciation':
                        return $this->appreciation($request);
                    break;
                    case 'participation':
                        return $this->participation($request);
                    break;
                }
            break;
            case 'attendance':
                return $this->attendance($request);
            break;
        }
    }

    public function attendance($request){
        $session = $request->krdwrks;
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($session);

        $data = EventSession::with('attendees.participant.detail.sex','venue','schedules','managers')->where('id',$id)->first();
        $url = $_SERVER['HTTP_HOST'].'/verification/'.$session;
        $qrCode = new QrCode($url);
        $qrCode->setSize(300);
        $pngWriter = new PngWriter();
        $qrCodeImageString = $pngWriter->write($qrCode)->getString();
        $base64Image = 'data:image/png;base64,' . base64_encode($qrCodeImageString);

        foreach ($data->attendees as $attendee) {
            if (!empty($attendee->participant->detail->signature)) {
                dd($attendee->participant->detail->signature);
                $attendee->participant->detail->signature_base64 = ($attendee->participant->detail->signature) ? $this->convertToBase64($attendee->participant->detail->signature) : null;
            }
        }

        $array = [
            'qrCodeImage' => $base64Image,
            'date' => $this->dateRangeText($data->schedules),
            'head' => $data->managers->firstWhere('type', 'Head'),
            'data' => $data
        ]; 

        $pdf = \PDF::loadView('prints.attendance',$array)->setPaper('a4', 'landscape');
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "PAGE $pageNumber OF $pageCount";
            $font = $fontMetrics->get_font("Helvetica", "normal");
            $size = 7;
            $width = $fontMetrics->get_text_width($text, $font, $size);
            $x = 63; // left margin
            $y = $canvas->get_height() - 47; // 20pt from bottom
            $canvas->text($x, $y, $text, $font, $size);
        });
        return $pdf->stream('attendance.pdf');
    }

    public function appearance($request){
        $participant = $request->krdwrks;

        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($participant);

        $data = EventSessionParticipant::with('participant','session.event.detail.municipality')->where('id',$id)->first();

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

        $pdf = \PDF::loadView('certificates.appearance',$array)->setPaper('a4', 'portrait');
        // Mail::to($data->participant->email)->send(new CertificateMail($array, $pdf));

        return $pdf->stream('certificate.pdf');
    }

    public function appreciation($request){
        $participant = $request->krdwrks;

        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($participant);

        $data = EventSessionParticipant::with('participant','session.venue','session.event.detail.municipality')->where('id',$id)->first();

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

        $pdf = \PDF::loadView('certificates.appreciation',$array)->setPaper('a4', 'landscape');
        Mail::to($data->participant->email)->send(new CertificateMail($array, $pdf));
        return $pdf->stream('certificate.pdf');
    }

    public function participation($request){
        $participant = $request->krdwrks;

        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($participant);

        $data = EventSessionParticipant::with('participant','session.venue','session.event.detail.municipality')->where('id',$id)->first();

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

        $pdf = \PDF::loadView('certificates.participation',$array)->setPaper('a4', 'landscape');
        return $pdf->stream('certificate.pdf');
    }

    private  function dateRangeText($schedules) {
        $start = $schedules[0]['date'];
        $end   = $schedules[0]['date'];

        foreach ($schedules as $s) {
            if ($s['date'] < $start) {
                $start = $s['date'];
            }
            if ($s['date'] > $end) {
                $end = $s['date'];
            }
        }

        // Format date
        $formatDate = function($dateStr) {
            return date("F j, Y", strtotime($dateStr));
        };

        return $start === $end
            ? $formatDate($start)
            : $formatDate($start) . " - " . $formatDate($end);
    }

    private function convertToBase64($path)
    {
        // If you store public files like: storage/app/public/signatures/filename.png
        // and you saved the DB value like: signatures/filename.png
        if (Storage::disk('public')->exists($path)) {
            $file = Storage::disk('public')->get($path);
            $mime = Storage::disk('public')->mimeType($path);
            return 'data:' . $mime . ';base64,' . base64_encode($file);
        }

        // If you stored a full URL instead of a storage path:
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            try {
                $file = file_get_contents($path);
                $mime = @mime_content_type($path) ?: 'image/png';
                return 'data:' . $mime . ';base64,' . base64_encode($file);
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }

}
