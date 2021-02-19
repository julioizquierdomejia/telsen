<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ot;
//use App\Models\Area;

class DashboardController extends Controller
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

      $role_names = validateActionbyRole();
      $admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);

        $users = User::where('id', '<>', 1)->get();
        $all_ots = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')
                    ->where('ots.enabled', 1)
                    ->orderBy('ots.created_at', 'asc')
                    ->get();

        $priority_count = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')
                    ->where('ots.enabled', 1)
                    ->where('ots.priority', 1)
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'ee_disapproved');
                        $query->orWhere("status.name", "=", 'me_disapproved');
                    })
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'cc_disapproved');
                        $query->orWhere("status.name", "=", 'rdi_disapproved');
                    })
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'ot_closure');
                    })
                    ->count();

        $ots = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')
                    ->where('ots.enabled', 1)
                    ->orderBy('ots.created_at', 'desc')
                    ->limit(10)
                    ->get();

        $attended_ots = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')
                    ->whereHas('statuses', function ($query) {
                            $query->where("status.name", "=", 'delivery_generated');
                        })
                    ->where('ots.enabled', 1)
                    ->get()
                    ->count();

        $pending_ots = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')
                    ->whereDoesntHave('statuses', function ($query) {
                            $query->where("status.name", "=", 'delivery_generated');
                        })
                    ->where('ots.enabled', 1)
                    ->get()
                    ->count();

        $avarage_ots = \DB::select( 'SELECT year(created_at), month(created_at) month_prom, AVG(month(created_at)) FROM ots
     GROUP BY year(created_at), month(created_at)
     ORDER BY year(created_at), month(created_at)' );
        if (count($avarage_ots)) {
          $avarage = number_format(end($avarage_ots)->month_prom, 0);
        } else {
          $avarage = 0;
        }

        $ots_count = $all_ots->count();

        $greetings = self::Greetings();

        //$areas = Area::where('areas.enabled', 1)->where('areas.id', '<>', 1)->get();
        return view('dashboard.index', compact('users', 'ots', 'ots_count', 'priority_count', 'pending_ots', 'attended_ots', 'avarage', 'greetings', 'admin'));
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
