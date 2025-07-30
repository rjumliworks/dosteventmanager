<?php

namespace App\Http\Resources;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionViewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $key = $hashids->encode($this->id);

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
            'key' => $key,
            'code' => $this->code,
            'title' => $this->title,
            'schedules' => $this->schedules,
            'detail' => $this->detail,
            'venue' => $this->venue,
            'activities' => $this->activities,
            'managers' => $this->managers,
            'participants' => $this->participants,
            'attendees' => $this->attendees,
            'status' => $this->status,
            'event' => new EventViewResource($this->event),
            'is_closed' => ($this->is_closed) ? true : false,
            'is_invitational' => ($this->is_invitational) ? true : false,
            'is_exclusive' => ($this->is_exclusive) ? true : false,
            'is_limited' => ($this->is_limited) ? true : false,
            'has_registration' => ($this->has_registration) ? true : false,
            'link' => ($this->has_registration) ? base64_encode($key) : '',
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
