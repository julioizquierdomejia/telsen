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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception', 'mechanical', 'electrical']);

        $usuario = User::all();
        $ots = Ot::where('enabled', 1)->get();
        //$areas = Area::where('areas.enabled', 1)->where('areas.id', '<>', 1)->get();
        return view('home', compact('usuario', 'ots'));
    }
}
