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
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(LogSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(ModelMotorSeeder::class);
        $this->call(BrandMotorSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(AreaServicesSeeder::class);
    }
}
