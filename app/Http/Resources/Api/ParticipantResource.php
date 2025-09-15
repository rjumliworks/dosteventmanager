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
            'avatar' => asset('storage/'.$this->detail->avatar),
            'signature' => asset('storage/'.$this->detail->signature),
            'designation' => $this->detail->designation,
            'affiliation' => $this->detail->affiliation,
            'birthdate' => $this->detail->birthdate,
            'type' => $this->detail->type,
            'sex' => $this->detail->sex,
            'is_completed' => $this->is_completed
        ];
    }
}
