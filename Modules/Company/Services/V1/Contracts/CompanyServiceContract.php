<?php

namespace Modules\Company\Services\V1\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Company\App\Models\Company;

interface CompanyServiceContract
{
    public function paginate(int $perPage): LengthAwarePaginator;
    public function getContactsForCompany(Company $company): mixed;

}
