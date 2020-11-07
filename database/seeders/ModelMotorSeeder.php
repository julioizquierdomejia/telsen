<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ModelMotor;

class ModelMotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new ModelMotor();
        $model->name = 'Ford Mustang Ecoboost';
        $model->enabled = 1;
        $model->save();

        $model = new ModelMotor();
        $model->name = 'Alfa Romeo Giulia/Stelvio';
        $model->enabled = 1;
        $model->save();
    }
}
