<?php

namespace Modules\Contact\App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Company\App\Models\Company;
use Modules\Contact\Database\Factories\ContactFactory;
use Modules\Note\App\Models\Note;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Contact
 *
 * @package Modules\Contact\App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string|null $address
 * @property Carbon|null $birthday
 * @property int|null $company_id
 *
 * @property-read Company|null $company
 * @property-read Collection|Note[] $notes
 */
class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'address', 'birthday', 'company_id'];

    /**
     * Get the company associated with the contact.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the notes associated with the contact.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    protected static function newFactory(): ContactFactory
    {
        return ContactFactory::new();
    }

    public function scopeSearch($query)
    {
        $request = request();
        return $query->when($request->keyword, function ($q) use ($request) {
            $q->where('name', 'like', "%$request->keyword%");
            $q->orWhereHas('company', function ($queryBuilder) use ($request) {
                $queryBuilder->where('name', 'like', "%$request->keyword%");
            });
        });
    }
}
