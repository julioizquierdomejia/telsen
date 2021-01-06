<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkAdditionalInformation;
use App\Models\WorkAdditionalInformation;

class WorkAdditionalInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brand = new WorkAdditionalInformation();
        $brand->name = 'WEG';
        $brand->enabled = 1;
        $brand->save();

        $brand = new WorkAdditionalInformation();
        $brand->name = 'ABB';
        $brand->enabled = 1;
        $brand->save();

        $brand = new WorkAdditionalInformation();
        $brand->name = 'BALDOR';
        $brand->enabled = 1;
        $brand->save();

        $brand = new WorkAdditionalInformation();
        $brand->name = 'n/a';
        $brand->enabled = 1;
        $brand->save();

        $brand = new WorkAdditionalInformation();
        $brand->name = 'TATUNG';
        $brand->enabled = 1;
        $brand->save();
    }
}
