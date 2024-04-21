<?php

namespace Modules\Company\App\Repositories\V1;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Company\App\Models\Company;
use Modules\Company\App\Repositories\V1\Contracts\CompanyRepositoryContract;

class CompanyRepository implements CompanyRepositoryContract
{
    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Company::paginate($perPage);
    }
}
