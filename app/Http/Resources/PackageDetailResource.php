<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageDetailResource extends JsonResource
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
            'package_id' => $this->package_id,
            'exam_id' => $this->exam_id,
            'max_exam_attempt' => $this->max_exam_attempt,
            'exam_name' => $this->exam->title ?? null,
        ];
    }
}
