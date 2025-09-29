<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MockTestResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           'id'                        => $this->id,
            'candidate_id'             => $this->candidate_id,
            'question_set'             => $this->question_set,
            'reading_answered'         => $this->reading_answered,
            'correct_reading_answer'   => $this->correct_reading_answer,
            'wrong_reading_answer'     => $this->wrong_reading_answer,
            'listening_answered'       => $this->listening_answered,
            'correct_listening_answer' => $this->correct_listening_answer,
            'wrong_listening_answer'   => $this->wrong_listening_answer,
            'created_at'               => date('Y-m-d h:i:s',strtotime($this->created_at)),
            'updated_at'               => date('Y-m-d h:i:s',strtotime($this->updated_at)),

        ];
    }
}
