<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Models\EventSessionParticipant;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Mail\CertificateMail;
use Illuminate\Support\Facades\Mail;

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
        }
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

}
