<?php

namespace Modules\Contact\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\App\resources\CompanyResource;
use Modules\Contact\App\Models\Contact;
use Modules\Note\App\resources\NoteResource;

/** @mixin Contact */
class ContactResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'notes' => NoteResource::collection($this->whenLoaded('notes')),
        ];
    }
}
