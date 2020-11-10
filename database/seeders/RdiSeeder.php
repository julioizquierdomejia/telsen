<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//use App\Models\Rdi;
use App\Models\RdiCriticalityType;
use App\Models\RdiMaintenanceType;

class RdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//RdiCriticalityType
        $rdictype = new RdiCriticalityType();
        $rdictype->name = 'ATENCIÓN NORMAL';
        $rdictype->enabled = 1;
        $rdictype->save();

        $rdictype = new RdiCriticalityType();
        $rdictype->name = 'URGENTE';
        $rdictype->enabled = 1;
        $rdictype->save();

        $rdictype = new RdiCriticalityType();
        $rdictype->name = 'EMERGENCIA';
        $rdictype->enabled = 1;
        $rdictype->save();

        //RdiMaintenanceType
        $rdimtype = new RdiMaintenanceType();
        $rdimtype->name = 'PREVENTIVO';
        $rdimtype->enabled = 1;
        $rdimtype->save();

        $rdimtype = new RdiMaintenanceType();
        $rdimtype->name = 'CORRECTIVO';
        $rdimtype->enabled = 1;
        $rdimtype->save();

        $rdimtype = new RdiMaintenanceType();
        $rdimtype->name = 'GARANTIA';
        $rdimtype->enabled = 1;
        $rdimtype->save();
    }
}
