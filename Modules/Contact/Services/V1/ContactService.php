<?php

namespace Modules\Contact\Services\V1;

use Modules\Company\App\Models\Company;
use Modules\Contact\App\Models\Contact;
use Modules\Contact\App\Repositories\V1\Contracts\ContactRepositoryContract;
use Modules\Contact\Services\V1\Contracts\ContactServiceContract;
use Illuminate\Database\Eloquent\Collection;

class ContactService implements ContactServiceContract
{
    protected ContactRepositoryContract $contactRepository;

    public function __construct(ContactRepositoryContract $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function getAll(): Collection
    {
        return $this->contactRepository->getAll();
    }

    public function create(array $data): Contact
    {
        return $this->contactRepository->create($data);
    }

    public function createMultipleForCompany(Company $company, array $data): array
    {
        return $this->contactRepository->createMultipleForCompany($company, $data);
    }


    public function update(Contact $contact, array $data): Contact
    {
        return $this->contactRepository->update($contact, $data);
    }

    public function addNotesToContact(Contact $contact, array $noteData): Contact
    {
        return $this->contactRepository->addNotesToContact($contact, $noteData);
    }
}
