<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'id' => $this->getId(),
            'seller' => new SellerResource($this->getSeller()),
            'amount' => $this->getAmount(),
            'commission' => $this->getCommission(),
            'date' => $this->getDate()->format('Y-m-d H:i:s'),
        ];
    }
}
