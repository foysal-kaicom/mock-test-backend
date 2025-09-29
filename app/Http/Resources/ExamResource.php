<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                'id'=>$this->id,
                'slug'=>$this->slug,
                'title'=>$this->title,
                'fee'=>(int)$this->fee .' BDT',
                'exam_date'=>date('d-M-Y',strtotime($this->exam_date)),
                'start_time'=>date('h:i A',strtotime($this->start_time)),
                'end_time'=>date('h:i A',strtotime($this->end_time)),
                'application_deadline'=>date('d-M-Y',strtotime($this->application_deadline)),
                'result_publish_date'=>date('d-M-Y',strtotime($this->result_publish_date)),
                'available_to_apply'=>Carbon::parse($this->application_deadline)->isFuture()
        ];
    }
}
