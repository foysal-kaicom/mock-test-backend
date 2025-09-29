<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'proficiency_level' => $this->proficiency_level,
            'title' => $this->title,
            'type' => $this->type,
            'options' => $this->mockTestQuestionOption    
        ];
    }
}
