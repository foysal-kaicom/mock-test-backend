<?php

namespace App\Mail;

use App\Models\Candidate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResultEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $listeningScore;
    public $readingScore;
    public $totalScore;
    public $examName;

    /**
     * Create a new message instance.
     *
     * @param Candidate $candidate
     * @param float $listeningScore
     * @param float $readingScore
     * @param float $totalScore
     * @return void
     */
    public function __construct(Candidate $candidate, $listeningScore, $readingScore, $totalScore, $examName)
    {
        $this->candidate = $candidate;
        $this->listeningScore = $listeningScore;
        $this->readingScore = $readingScore;
        $this->totalScore = $totalScore;
        $this->examName = $examName;
    }

    /**
     * Build the message.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->subject('Congratulations!🎉 Your Mock test exam result is published.')
                    ->view('emails.result')
                    ->with([
                        'candidate' => $this->candidate,
                        'listeningScore' => $this->listeningScore,
                        'readingScore' => $this->readingScore,
                        'totalScore' => $this->totalScore,
                        'examName' => $this->examName,
                    ]);
    }
}
