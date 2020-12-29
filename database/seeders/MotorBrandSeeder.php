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
        $brand->name = 'WEG';
        $brand->enabled = 1;
        $brand->save();

        $brand = new MotorBrand();
        $brand->name = 'ABB';
        $brand->enabled = 1;
        $brand->save();

        $brand = new MotorBrand();
        $brand->name = 'BALDOR';
        $brand->enabled = 1;
        $brand->save();

        $brand = new MotorBrand();
        $brand->name = 'n/a';
        $brand->enabled = 1;
        $brand->save();

        $brand = new MotorBrand();
        $brand->name = 'TATUNG';
        $brand->enabled = 1;
        $brand->save();
    }
}
