<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$request->user()->authorizeRoles(['superadmin', 'admin', 'worker']);

        $rules = array(
            'name'        => 'string|min:3|required',
            'email'       => 'email|required|unique:users,email',
            'lastname'    => 'string|min:3|required',
            'mlastname'   => 'string|min:3|required',
            'phone'       => 'string|min:6',
            //'enabled'   => 'boolean|required',
        );
        $this->validate($request, $rules);

        $user = new User();
        
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        //$user_data->enabled = $request->input('enabled');
        $user->save();

        $user_data = new User();
        $user_data->name = $request->input('name');
        $user_data->user_id = $user->id;
        $user_data->lastname = $request->input('lastname');
        $user_data->mother_last_name = $request->input('mlastname');
        $user_data->save();

        activitylog('users', 'store', null, $user->toArray());

        return redirect('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        $users = Area::where('enabled', 1)->get();
        $services = Service::where('enabled', 1)
                ->where('user_id', $id)
                ->get();
        $user = Area::findOrFail($id);
        return view('users.edit', compact('user', 'users', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$request->user()->authorizeRoles(['superadmin', 'admin', 'worker']);
        
        $rules = array(
            'name'        => 'string|min:3|required',
            'email'       => 'email|required|unique:users,email',
            'password'    => 'string|min:6|required',
            'lastname'    => 'string|min:3|required',
            'mlastname'   => 'string|min:3|required',
            'phone'       => 'string|min:6',
            //'enabled'   => 'boolean|required',
        );
        $this->validate($request, $rules);

        $user = User::findOrFail($id);
        $original_data = $user->original();
        
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        //$user_data->enabled = $request->input('enabled');
        $user->save();

        $user_data = UserData::where('user_id', $id)->first();
        $user_data->name = $request->input('name');
        $user_data->lastname = $request->input('lastname');
        $user_data->mother_last_name = $request->input('mlastname');
        $user_data->save();

        activitylog('users', 'update', $original_data, $user->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated user!');
        return redirect('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Area $user)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
