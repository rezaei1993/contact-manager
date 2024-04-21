<?php

namespace Modules\Company\Services\V1;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Company\App\Models\Company;
use Modules\Company\App\Repositories\V1\Contracts\CompanyRepositoryContract;
use Modules\Company\Services\V1\Contracts\CompanyServiceContract;

class CompanyService implements CompanyServiceContract
{
    protected CompanyRepositoryContract $companyRepository;

    public function __construct(CompanyRepositoryContract $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }


    public function paginate(int $perPage): LengthAwarePaginator
    {
        return $this->companyRepository->paginate($perPage);
    }

    public function getContactsForCompany(Company $company):  mixed
    {
        return $company->contacts;
    }

}
