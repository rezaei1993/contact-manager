<?php

namespace Modules\Note\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Contact\App\Models\Contact;

class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Note\App\Models\Note::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph,
            'contact_id' => function () {
                return Contact::factory()->create()->id;
            },
        ];
    }
}

