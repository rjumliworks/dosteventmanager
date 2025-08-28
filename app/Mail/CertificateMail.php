<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; 
    protected $pdf;

    public function __construct($data, $pdf)
    {
        $this->data = $data;
        $this->pdf  = $pdf;
    }

    public function build()
    {
        return $this->subject('Your Certificate of Appearance')
            ->view('emails.certificate') // simple blade for the email body
            ->attachData($this->pdf->output(), 'certificate.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
