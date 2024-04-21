<?php

namespace Modules\Note\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Note\App\Models\Note;

/** @mixin Note */
class NoteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
        ];
    }
}
