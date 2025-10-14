<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CertificateClaimUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // You can pass data to the email view.
    public $candidateName; // You can pass data to the email view.

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $candidateName)
    {
        $this->data = $data;
        $this->candidateName = $candidateName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.certificate_claim_payment')
                    ->subject('Mock Test Certificate Payment Approved')
                    ->with([
                        'data' => $this->data,
                        'candidateName' => $this->candidateName
                    ]);
    }
}
