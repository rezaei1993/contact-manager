<?php

namespace Modules\Company\App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Company\App\Models\Company;
use Modules\Company\App\resources\CompanyResource;
use Modules\Company\Services\V1\Contracts\CompanyServiceContract;
use Modules\Contact\App\resources\ContactResource;

class CompanyController extends Controller
{
    protected CompanyServiceContract $companyService;

    public function __construct(CompanyServiceContract $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(): AnonymousResourceCollection
    {
        $companies = $this->companyService->paginate(10);
        return CompanyResource::collection($companies);
    }

    public function contacts(Company $company): AnonymousResourceCollection
    {
        $contacts = $this->companyService->getContactsForCompany($company);
        return ContactResource::collection($contacts);
    }
}
