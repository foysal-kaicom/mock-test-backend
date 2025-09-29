<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
                'category_name'=>$this->category_name,
                'content'=>$this->content,
                'featured_image'=>$this->featured_image,
                'is_featured'=>$this->is_featured,
                'author_name'=>$this->author_name,
                'author_designation'=>$this->author_designation,
                'created_by'=>$this->user->name,
                'published_at'=>date('d-M-Y',strtotime($this->published_at)),
               
        ];
    }
}
