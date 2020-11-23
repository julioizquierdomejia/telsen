<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AreaServicesSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(LogSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(MotorModelSeeder::class);
        $this->call(MotorBrandSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(RdiSeeder::class);
    }
}
