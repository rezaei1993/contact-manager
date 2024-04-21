<?php

namespace Modules\Company\App\Repositories\V1\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Company\App\Models\Company;

interface CompanyRepositoryContract
{
    public function paginate(int $perPage): LengthAwarePaginator;
}
