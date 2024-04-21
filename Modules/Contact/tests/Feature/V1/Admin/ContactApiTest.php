<?php

namespace Modules\Contact\tests\Feature\V1\Admin;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Company\App\Models\Company;
use Modules\Contact\App\Models\Contact;
use Modules\User\App\Models\User;
use Tests\TestCase;

class ContactApiTest extends TestCase
{
    use DatabaseTransactions;


    /**
     * @return void
     */
    public function testRetrieveListOfContacts(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $contacts = Contact::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/contacts');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'email', 'phone']
            ]
        ]);

        $this->assertEquals(5, count($response->json('data')));
    }


    /**
     * @return void
     */
    public function testCreateContactWithValidData()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $validContactData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'company_id' => Company::factory()->create()->id,
        ];

        $response = $this->postJson('/api/v1/contact', $validContactData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('contacts', $validContactData);
    }


    /**
     * @return void
     */
    public function testCreateContactWithInvalidData()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $invalidContactData = [
            // Missing required 'name' field
            'email' => 'john@example.com',
            'phone' => '123456789',
            'company_id' => Company::factory()->create()->id,
        ];

        $response = $this->postJson('/api/v1/contact', $invalidContactData);

        $response->assertStatus(422);
    }


    /**
     * @return void
     */
    public function testUpdateContactWithValidData()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $contact = Contact::factory()->create();

        $validContactData = [
            'name' => 'Updated Name',
            'email' => 'updated_email@example.com',
            'phone' => '987654321',
            'company_id' => Company::factory()->create()->id,
        ];

        $response = $this->patchJson("/api/v1/{$contact->id}/contact", $validContactData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('contacts', $validContactData);
    }


    /**
     * @return void
     */
    public function testUpdateContactWithInvalidData()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $contact = Contact::factory()->create();

        $invalidContactData = [
            // Missing required 'name' field
            'email' => 'updated_email@example.com',
            'phone' => '987654321',
            'company_id' => Company::factory()->create()->id,
        ];

        $response = $this->patchJson("/api/v1/{$contact->id}/contact", $invalidContactData);

        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testRetrieveSingleContact()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::factory()->create();

        $contact = Contact::factory()->create(['company_id' => $company->id]);
        $contact->notes()->createMany([
            ['content' => 'first note'],
            ['content' => 'second note'],
        ]);

        $response = $this->getJson("/api/v1/{$contact->id}/contact");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'email', 'phone', 'company', 'notes'
            ]
        ]);

        $response->assertJson([
            'data' => [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'company' => [
                    'id' => $company->id,
                    'name' => $company->name,
                    'email' => $company->email,
                    'phone' => $company->phone,
                ],
                'notes' => $contact->notes->map(function ($note) {
                    return [
                        'id' => $note->id,
                        'content' => $note->content,
                    ];
                })->toArray()
            ]
        ]);
    }


    /**
     * @return void
     */
    public function testBulkCreateContactsForCompany()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::factory()->create();

        $validContactData = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '123456789',
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane@example.com',
                'phone' => '987654321',
            ],
        ];

        $response = $this->postJson("/api/v1/companies/{$company->id}/contacts", $validContactData);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'email', 'phone']
            ]
        ]);

        $response->assertJson([
            'data' => $validContactData,
        ]);
    }

    /**
     * @return void
     */
    public function testAddNotesToContact()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::factory()->create();

        $contact = Contact::factory()->create(['company_id' => $company->id]);

        $validNoteData = [
            ['content' => 'third note'],
            ['content' => 'fourth note'],
        ];

        $response = $this->postJson("/api/v1/contacts/{$contact->id}/add-notes", $validNoteData);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'email', 'phone', 'company', 'notes'
            ]
        ]);

        $response->assertJson([
            'data' => [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'company' => [
                    'id' => $company->id,
                    'name' => $company->name,
                    'email' => $company->email,
                    'phone' => $company->phone,
                ],
                'notes' => [
                    ['id' => 1, 'content' => 'third note'],
                    ['id' => 2, 'content' => 'fourth note'],
                ]
            ]
        ]);
    }
}
