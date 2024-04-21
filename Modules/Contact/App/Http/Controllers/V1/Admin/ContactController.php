<?php

namespace Modules\Contact\App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Company\App\Models\Company;
use Modules\Contact\App\Http\Requests\V1\Admin\BulkCreateContactNotesRequest;
use Modules\Contact\App\Http\Requests\V1\Admin\BulkCreateContactsRequest;
use Modules\Contact\App\Http\Requests\V1\Admin\ContactRequest;
use Modules\Contact\App\Models\Contact;
use Modules\Contact\App\resources\ContactResource;
use Modules\Contact\Services\V1\Contracts\ContactServiceContract;


class ContactController extends Controller
{
    protected ContactServiceContract $contactService;

    public function __construct(ContactServiceContract $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $contacts = $this->contactService->getAll();
        return ContactResource::collection($contacts);
    }


    /**
     * @param ContactRequest $request
     * @return ContactResource
     */
    public function store(ContactRequest $request): ContactResource
    {
        $contact = $this->contactService->create($request->validated());

        return new ContactResource($contact->load('notes', 'company'));
    }

    /**
     * @param BulkCreateContactsRequest $request
     * @param Company $company
     * @return AnonymousResourceCollection
     */
    public function storeBulkForCompany(BulkCreateContactsRequest $request, Company $company): AnonymousResourceCollection
    {
        $data = $request->validated();
        $contacts = $this->contactService->createMultipleForCompany($company, $data);

        return ContactResource::collection($contacts);
    }

    /**
     * @param Contact $contact
     * @return ContactResource
     */
    public function show(Contact $contact): ContactResource
    {
        return new ContactResource($contact->load('notes', 'company'));
    }

    /**
     * @param ContactRequest $request
     * @param Contact $contact
     * @return ContactResource
     */
    public function update(ContactRequest $request, Contact $contact): ContactResource
    {
        $contact = $this->contactService->update($contact, $request->validated());

        return new ContactResource($contact->load('notes', 'company'));
    }

    /**
     * @param BulkCreateContactNotesRequest $request
     * @param Contact $contact
     * @return ContactResource
     */
    public function addNotesToContact(BulkCreateContactNotesRequest $request, Contact $contact): ContactResource
    {
        $noteData = $request->validated();
        $contact = $this->contactService->addNotesToContact($contact, $noteData);
        return new ContactResource($contact->load('notes', 'company'));
    }

    /**
     * @param string $query
     * @return AnonymousResourceCollection
     */
    public function search(string $query): AnonymousResourceCollection
    {
        $contacts = $this->contactService->search($query, 10);
        return ContactResource::collection($contacts);
    }
}
