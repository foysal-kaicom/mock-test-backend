<?php

namespace App\Mail;

use App\Models\CandidatePromotion;
use App\Models\Candidate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PromotionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public CandidatePromotion $promotion;
    public ?Candidate $candidate;

    public function __construct(CandidatePromotion $promotion, ?Candidate $candidate = null)
    {
        $this->promotion = $promotion;
        $this->candidate = $candidate;
    }

    public function build()
    {
        $subject = $this->promotion->title;

        return $this->subject($subject)
            ->view('emails.promotion')
            ->with([
                'promotion' => $this->promotion,
                'candidate' => $this->candidate,
            ]);
    }
}
