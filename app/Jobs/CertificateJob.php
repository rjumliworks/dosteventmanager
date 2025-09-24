<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\CertificateMail; 
use Illuminate\Support\Facades\Mail;

class CertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $data;
    protected $pdf;

    public function __construct($email, $data, $pdf)
    {
        $this->email = $email;
        $this->data = $data;
        $this->pdf = $pdf;
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new CertificateMail($this->data,$this->pdf));
    }
}
