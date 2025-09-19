<?php

namespace App\Http\Resources;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Resources\Json\JsonResource;

class ExhibitorViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $code = $this->code;
        $encrypted = Crypt::encrypt($code);
        $qrCode = new QrCode($encrypted);
        $qrCode->setSize(2000)->setMargin(10);;
        $logo = Logo::create(public_path('images/qrlogo.png'))->setResizeToWidth(400);      

        $pngWriter = new PngWriter();
        $qrCodeImageString = $pngWriter->write($qrCode,$logo)->getString();
        $qr = 'data:image/png;base64,' . base64_encode($qrCodeImageString);

        return [
            'title' => $this->title,
            'institution' => $this->institution,
            'qr' => $qr,
            'is_active' => $this->is_active
        ];
    }
}
