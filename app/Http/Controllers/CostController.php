<?php

namespace App\Http\Controllers;

//use App\Models\Cost;
use Illuminate\Http\Request;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        
        $costos = Cost::all();
        return view('costos.index', compact('costos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        return view('costos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $rules = array(
            'name'       => 'string|required|unique:costos',
            'enabled'      => 'boolean|required',
        );
        $this->validate($request, $rules);

        $cost = new Cost();
        
        $cost->name = $request->input('name');
        $cost->enabled = $request->input('enabled');

        $cost->save();

        activitylog('costos', 'store', null, $cost->toArray());

        $costos = Cost::where('enabled', 1)->get();
        return redirect('costos')->with('costos');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $cost = Client::findOrFail($id);

        return view('costos.show', compact('cost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $cost = Cost::findOrFail($id);
        return view('costos.edit', compact('cost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required|string|unique:costos,name,'.$id,
            'enabled'      => 'boolean|required',
        );
        $validator = \Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect('costos/' . $id . '/editar')
                ->withErrors($validator);
        } else {
            // store
            $cost = Cost::find($id);
            $original_data = $cost->toArray();

            $cost->name       = $request->get('name');
            $cost->enabled      = $request->get('enabled');
            $cost->save();

            activitylog('costos', 'update', $original_data, $cost->toArray());

            // redirect
            \Session::flash('message', 'Successfully updated cost!');
            return redirect('costos');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cost $cost)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
