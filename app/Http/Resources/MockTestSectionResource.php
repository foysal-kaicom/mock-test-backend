<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MockTestSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->slug == 'reading-comprehension') {

            $groups = collect();

            // 1st: take a group with question_quantity = 3
            $groups = $groups->merge(
                $this->mockTestQuestionGroup()
                    ->where('question_quantity', 3)
                    ->inRandomOrder()
                    ->take(1)
                    ->get()
            );

            // 2nd: take a group with question_quantity = 4
            $groups = $groups->merge(
                $this->mockTestQuestionGroup()
                    ->where('question_quantity', 4)
                    ->inRandomOrder()
                    ->take(1)
                    ->get()
            );

            // 3rd: again take a group with question_quantity = 3
            $groups = $groups->merge(
                $this->mockTestQuestionGroup()
                    ->where('question_quantity', 3)
                    ->inRandomOrder()
                    ->whereNotIn('id', $groups->pluck('id'))
                    ->take(1)
                    ->get()
            );

            $resultGroups = MockTestGroupResource::collection($groups);
        } else {
            // Default: just take $this->question_limit groups
            $resultGroups = MockTestGroupResource::collection(
                $this->mockTestQuestionGroup()
                    ->inRandomOrder()
                    ->take($this->question_limit)
                    ->get()
            );
        }

        return [
            'id'              => $this->id,
            'slug'            => $this->slug,
            'title'           => $this->title,
            'module_name'     => $this->mockTestModule->name ?? null,
            'sample_question' => $this->sample_question,
            'group'           => $resultGroups,
        ];
    }
}
