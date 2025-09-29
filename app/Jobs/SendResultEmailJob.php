<?php

namespace App\Jobs;

use App\Mail\ResultEmail;
use App\Models\Booking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendResultEmailJob implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    public $booking; // Booking data for the candidate

    /**
     * Create a new job instance.
     *
     * @param Booking $booking
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $candidate = $this->booking->candidate;
        $listeningScore = $this->booking->listening_score;
        $readingScore = $this->booking->reading_score;
        $totalScore = $this->booking->result;
        $examName = $this->booking->exam->title;

        Mail::to($candidate->email)->send(new ResultEmail($candidate, $listeningScore, $readingScore, $totalScore, $examName));
    }
}
