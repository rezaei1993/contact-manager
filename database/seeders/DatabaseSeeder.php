<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Award\Database\Seeders\AwardDatabaseSeeder;
use Modules\Company\App\Models\Company;
use Modules\User\App\Models\User;
use Modules\User\Database\Seeders\UserDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Company::factory()->count(10)->create();
        $this->call([
            UserDatabaseSeeder::class,
        ]);
    }
}
