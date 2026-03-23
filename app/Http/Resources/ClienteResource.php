<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'zipcode' => $this->zipcode,
            'provincia_id' => $this->provincia_id,
            'vendedor_id' => $this->vendedor_id,
            'tipo' => $this->tipo,
            'activo' => $this->activo,
        ];
    }
}
