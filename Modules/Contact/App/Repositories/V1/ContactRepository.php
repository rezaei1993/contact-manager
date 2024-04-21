<?php

namespace Modules\Contact\App\Repositories\V1;

use Illuminate\Database\Eloquent\Collection;
use Modules\Company\App\Models\Company;
use Modules\Contact\App\Models\Contact;
use Modules\Contact\App\Repositories\V1\Contracts\ContactRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactRepository implements ContactRepositoryContract
{
    public function findById($id): Contact
    {
        return Contact::findOrFail($id);
    }

    public function getAll(): Collection
    {
        return Contact::search()->with(['notes','company'])->get();
    }

    public function create(array $data): Contact
    {
        return Contact::create($data);
    }

    public function createMultipleForCompany(Company $company, array $data): array
    {
        return collect($data)->map(function ($contactData) use ($company) {
            return $company->contacts()->create($contactData);
        })->all();
    }

    public function update(Contact $contact, array $data): Contact
    {
        $contact->update($data);
        return $contact;
    }

    public function addNotesToContact(Contact $contact, array $noteData): Contact
    {
        $contact->notes()->createMany($noteData);
        return $contact->fresh();
    }


    public function search(string $query, int $perPage): LengthAwarePaginator
    {
        return Contact::where('name', 'like', "%$query%")
            ->orWhereHas('company', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%");
            })
            ->paginate($perPage);
    }
}
