<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MotorBrand;

class MotorBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brand = new MotorBrand();
        $brand->name = 'Toyota';
        $brand->enabled = 1;
        $brand->save();

        $brand = new MotorBrand();
        $brand->name = 'Hyundai';
        $brand->enabled = 1;
        $brand->save();

        $brand = new MotorBrand();
        $brand->name = 'Ford';
        $brand->enabled = 1;
        $brand->save();
    }
}
