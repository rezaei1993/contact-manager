<?php

namespace Modules\Company\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Company\Database\Factories\CompanyFactory;
use Modules\Contact\App\Models\Contact;

/**
 * Class Company
 *
 * @package Modules\Company\App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Contact[] $contacts
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];

    /**
     * Get the contacts associated with the company.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    protected static function newFactory(): CompanyFactory
    {
        return CompanyFactory::new();
    }
}
