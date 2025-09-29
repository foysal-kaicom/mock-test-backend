<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Models\CandidatePromotion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\PromotionMail;

class SendPromotionEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $promotionId;
    public int $examId;

    public function __construct(int $promotionId, int $examId)
    {
        $this->promotionId = $promotionId;
        $this->examId = $examId;
    }

    public function handle(): void
    {
        $promotion = CandidatePromotion::findOrFail($this->promotionId);

        Booking::where('exam_id', $this->examId)
            ->select('candidate_id', 'id')
            ->distinct()
            ->with(['candidate:id,first_name,last_name,email'])
            ->orderBy('id', 'asc')
            ->chunkById(50, function ($bookings) use ($promotion) {
                foreach ($bookings as $booking) {
                    $candidate = $booking->candidate;
                    if (!$candidate || empty($candidate->email)) {
                        continue;
                    }
    
                Mail::to($candidate->email)
                    ->queue(new PromotionMail($promotion, $candidate));
            }
        });
    
    }
}
