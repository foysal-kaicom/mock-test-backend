<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'exam_title' => $this->exam->title,
            'center' => $this->center->name,
            'center_address' => $this->center->address,
            'exam_date' => date('d-M-Y', strtotime($this->exam->exam_date)),
            'created_at' => date('d-M-Y', strtotime($this->created_at)),
            'exam_day' => date('l', strtotime($this->exam->exam_date)),
            'exam_time' => date('h:i A', strtotime($this->exam->start_time)),
            'exam_end_time' => date('h:i A', strtotime($this->exam->end_time)),
            'paid_amount' => $this->total_payable . " BDT",
            'payment_status' => $this->payment_status,
            'booking_status' => $this->status,
            'progress_step' => $this->getStep(),
            'admit_card_file' => $this->admit_card_file,
            'result'=>$this->result,
            'listening_score'=>$this->listening_score,
            'reading_score'=>$this->reading_score,
            'is_certificate_claimed'=>$this->is_certificate_claimed,
            'certificate_claimed_status'=>optional($this->certificate_payment)->status,
        ];
    }

    public function getStep(): int
    {
        return match (true) {
            $this->is_certificate_claimed    => 6,
            (bool) $this->result              => 5,
            (bool) $this->admit_card_file     => 4,
            $this->payment_status === 'success' => 3,
            default                           => 2, // fallback if no condition matches
        };
    }
}
