<?php

namespace Modules\Contact\Services\V1\Contracts;

use Modules\Company\App\Models\Company;
use Modules\Contact\App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;

interface ContactServiceContract
{
    public function create(array $data): Contact;

    public function createMultipleForCompany(Company $company, array $data): array;

    public function update(Contact $contact, array $data): Contact;

    public function addNotesToContact(Contact $contact, array $noteData): Contact;

    public function getAll(): Collection;
}
