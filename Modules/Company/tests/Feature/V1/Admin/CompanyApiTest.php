<?php

namespace Modules\Company\tests\Feature\V1\Admin;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Company\App\Models\Company;
use Modules\Contact\App\Models\Contact;
use Modules\User\App\Models\User;
use Tests\TestCase;

class CompanyApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test retrieving list of companies.
     *
     * @return void
     */
    public function testRetrieveListOfCompanies(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

         Company::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/companies');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);

        $response->assertJson([
            'meta' => ['total' => 5]
        ]);
    }


    public function testRetrieveContactsOfCompany()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::factory()->create();

        $contacts = Contact::factory()->count(3)->create(['company_id' => $company->id]);

        $secondCompany = Company::factory()->create();
        $secondCompanyContacts = Contact::factory()->count(2)->create(['company_id' => $secondCompany->id]);


        $response = $this->getJson("/api/v1/companies/{$company->id}/contacts");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'email', 'phone']
            ]
        ]);

        $this->assertEquals(3, count($response->json('data')));
    }
}
