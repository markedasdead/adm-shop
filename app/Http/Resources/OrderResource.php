<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
          "id" => $this->order_id,
          "status" => $this->status,
          "product" => OrderItemProductResource::make($this->product)
        ];
    }
}
