<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MotorModel;

class MotorModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new MotorModel();
        $model->name = 'Ford Mustang Ecoboost';
        $model->enabled = 1;
        $model->save();

        $model = new MotorModel();
        $model->name = 'Alfa Romeo Giulia/Stelvio';
        $model->enabled = 1;
        $model->save();
    }
}
