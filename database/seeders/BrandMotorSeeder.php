<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BrandMotor;

class BrandMotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brand = new BrandMotor();
        $brand->name = 'Toyota';
        $brand->enabled = 1;
        $brand->save();

        $brand = new BrandMotor();
        $brand->name = 'Hyundai';
        $brand->enabled = 1;
        $brand->save();

        $brand = new BrandMotor();
        $brand->name = 'Ford';
        $brand->enabled = 1;
        $brand->save();
    }
}
