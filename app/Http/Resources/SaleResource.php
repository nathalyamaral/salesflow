<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * Resource for Sale response formatting.
 */
class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'seller' => new SellerResource($this->seller),
            'amount' => $this->amount,
            'commission' => $this->commission,
            'date' => $this->date->format('Y-m-d H:i:s'),
        ];
    }
}
