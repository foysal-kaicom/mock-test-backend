<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSubscriptionResource extends JsonResource
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
            'payment_status' => $this->payment_status,
            'title' => $this->title,
            'total_payable' => $this->total_payable,
            'package_name' => $this->package ? $this->package->name : null,
            'date' => $this->created_at->toDateString(),
            'date' => Carbon::parse($this->created_at)->format('h:i A - d-M-Y'),
            'is_free' => $this->package ? $this->package->is_free : null,
        ];
        return parent::toArray($request);
    }
}
