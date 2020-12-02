<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ot;
//use App\Models\Area;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //$request->user()->authorizeRoles(['superadmin', 'admin', 'reception', 'mechanical', 'electrical']);

        $enabled_ots = [];
        $pending_ots = [];

        $users = User::all();
        $ots = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')
                    ->where('ots.enabled', 1)->get();

        $avarage_ots = \DB::select( 'SELECT AVG( ots_num ) ot_prom FROM (
                        SELECT created_at, COUNT( DISTINCT id ) ots_num
                        FROM  `ots` 
                        GROUP BY MONTH( created_at )
                        ) ots_per_month' );
        if (count($avarage_ots)) {
          $avarage = number_format($avarage_ots[0]->ot_prom, 0);
        } else {
          $avarage = 0;
        }

        foreach ($ots as $key => $ot) {
            $ot_status = \DB::table('status_ot')
                  ->join('status', 'status_ot.status_id', '=', 'status.id')
                  ->where('status_ot.ot_id', '=', $ot->id)
                  ->select('status_ot.status_id', 'status.id', 'status.name')
                  ->get();
            $ot_status_arr = array_column($ot_status->toArray(), "name");
            /*if ($ot_status->last()->status_id == 1) {
                $pending_ots[] = $ot;
            }*/
            if (count($ot_status_arr) > 1 && !in_array("cc_disapproved", $ot_status_arr) && !in_array("rdi_disapproved", $ot_status_arr)) {
                $enabled_ots[] = $ot;
            } else {
              $pending_ots[] = $ot;
            }
        }

        $enabled_ots = count($enabled_ots);
        $pending_ots = count($pending_ots);
        $ots_count = count($ots);

        $greetings = self::Greetings();

        //$areas = Area::where('areas.enabled', 1)->where('areas.id', '<>', 1)->get();
        return view('home', compact('users', 'ots', 'ots_count', 'pending_ots', 'enabled_ots', 'avarage', 'greetings'));
    }

    function Greetings() {
      $hours = gmdate('H') - 5;
      if ($hours >= 0 && $hours <= 12) {
          return "Buenos días";
      } else {
          if ($hours > 12 && $hours <= 17) {
              return "Buenas tardes";
          } else {
              return "Buenas noches";
          }
      }
    }
}
