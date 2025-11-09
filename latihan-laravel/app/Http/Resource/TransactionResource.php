<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'type'        => $this->type,
            'title'       => $this->title,
            'note'        => $this->note,
            'amount'      => $this->amount,
            'occurred_at' => $this->occurred_at?->toDateString(),
            'category'    => $this->whenLoaded('category', fn () => $this->category->name),
            'cover_url'   => $this->cover_path ? asset('storage/' . $this->cover_path) : null,
        ];
    }
}
