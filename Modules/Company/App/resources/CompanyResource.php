<?php

namespace Modules\Company\App\resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\App\Models\Company;

/** @mixin Company */
class CompanyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}
