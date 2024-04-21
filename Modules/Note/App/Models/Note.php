<?php

namespace Modules\Note\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Contact\App\Models\Contact;
use Modules\Note\Database\Factories\NoteFactory;

/**
 * Class Note
 *
 * @package Modules\Note\App\Models
 *
 * @property int $id
 * @property string $content
 * @property int $contact_id
 *
 * @property-read Contact $contact
 */
class Note extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'contact_id'];

    /**
     * Get the contact associated with the note.
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    protected static function newFactory(): NoteFactory
    {
        return NoteFactory::new();
    }
}
