<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $code = $this->code;
        $qrCode = new QrCode($code);
        $qrCode->setSize(2000)->setMargin(10);;
        $logo = Logo::create(public_path('images/qrlogo.png'))->setResizeToWidth(400);                        

        $pngWriter = new PngWriter();
        $qrCodeImageString = $pngWriter->write($qrCode,$logo)->getString();
        $qr = 'data:image/png;base64,' . base64_encode($qrCodeImageString);

        $sig = $pngWriter->write($qrCode,$logo)->getString();
        $esig = 'data:image/png;base64,' . base64_encode($sig);

        return [
            'qr' => $qr,
            'id' => $this->id,
            'code' => $this->code,
            'email' => $this->email,
            'contact_no' => $this->contact_no,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'suffix' => $this->suffix,
            'avatar' => ($this->detail->avatar != 'avatar.jpg') ? asset('storage/'.$this->detail->avatar) : null,
            'signature' => ($this->detail->signature) ? $this->convertToBase64(asset('storage/'.$this->detail->signature)) : null,
            'designation' => $this->detail->designation,
            'affiliation' => $this->detail->affiliation,
            'birthdate' => $this->detail->birthdate,
            'type' => $this->detail->type,
            'sex' => $this->detail->sex,
            'is_completed' => $this->is_completed
        ];
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
