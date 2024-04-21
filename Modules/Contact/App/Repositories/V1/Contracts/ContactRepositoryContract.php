<?php

namespace Modules\Contact\App\Repositories\V1\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Modules\Company\App\Models\Company;
use Modules\Contact\App\Models\Contact;

interface ContactRepositoryContract
{
    public function findById($id): Contact;

    public function getAll(): Collection;

    public function create(array $data): Contact;

    public function createMultipleForCompany(Company $company, array $data): array;

    public function update(Contact $contact, array $data): Contact;

    public function addNotesToContact(Contact $contact, array $noteData): Contact;
}
