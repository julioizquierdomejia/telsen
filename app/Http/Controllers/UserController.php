<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserData;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Area;
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
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        $users = User::join('user_data', 'user_data.user_id', '=', 'users.id')
                ->join('areas', 'areas.id', '=' ,'user_data.area_id')
                ->select('users.*', 'areas.name as area', 'user_data.name', \DB::raw('CONCAT(user_data.last_name, " ", user_data.mother_last_name) AS lastname'))
                ->get();
        return view('users.index', compact('users'));
    }

    public function getUsers(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        //$totalRecords = User::select('count(*) as allcount')->join('user_data', 'user_data.user_id', '=', 'users.id')->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')->join('user_data', 'user_data.user_id', '=', 'users.id')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = User::leftJoin('user_data', 'user_data.user_id', '=', 'users.id')
                ->join('areas', 'areas.id', '=' ,'user_data.area_id')
                ->select('users.*', 'areas.name as area', 'user_data.name', \DB::raw('CONCAT(user_data.last_name, " ", user_data.mother_last_name) AS lastname'))
                ->skip($start)
                ->take($rowperpage)
                ->where('user_data.name', 'like', '%' .$searchValue . '%')
                ->orderBy($columnName, $columnSortOrder)
                ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $name = $record->name;
            $lastname = $record->lastname;
            $roles = '<ul class="list-unstyled mb-0">';
            foreach ($record->roles as $role) {
                $roles .= '<li class="my-1"><span class="badge badge-primary d-block">'.$role->name.'</span></li>';
            }
            $roles .= '</ul>';
            $area = '<span class="badge badge-light d-block">'.$record->area.'</span>';
            $email = $record->email;
            $enabled = ($record->enabled == 1 ? '<span class="badge badge-success d-block">Activo</span>' : '<span class="badge badge-secondary d-block">Inactivo</span>');

            $tools = '<button type="button" class="btn btn-sm btn-danger btn-mdelete" data-userid="'.$record->id.'" data-state="0" data-toggle="modal" data-target="#modalUser" title="Desactivar usuario"><i class="fal fa-trash"></i></button> '. ($record->enabled == 0 ? '<button type="button" class="btn btn-sm btn-primary btn-mdelete" data-userid="'.$record->id.'" data-state="1" data-toggle="modal" data-target="#modalUser" title="Restaurar usuario"><i class="fal fa-trash-restore"></i></button>' : '');

            $data_arr[] = array(
              "id" => $id,
              "name" => $name,
              "lastname" => $lastname,
              "role" => $roles,
              "area" => $area,
              "email" => $email,
              "enabled" => $enabled,
              "tools" => $tools
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $records->count(),
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $roles = Role::all();
        $areas = Area::where('enabled', 1)->get();

        return view('users.create', compact('roles', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $rules = array(
            'name'        => 'string|min:3|required',
            'email'       => 'email|required|unique:users,email',
            'lastname'    => 'string|min:3|required',
            'mlastname'   => 'string|min:3|required',
            'phone'       => 'string|min:6',
            'roles'     => 'array|min:1',
            'area_id'     => 'integer|required',
            'password'    => 'string|min:6',
            //'enabled'   => 'boolean|required',
        );
        $this->validate($request, $rules);

        $user = new User();
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        //$user_data->enabled = $request->input('enabled');
        $user->save();

        $user_data = new UserData();
        $user_data->name = $request->input('name');
        $user_data->user_id = $user->id;
        $user_data->last_name = $request->input('lastname');
        $user_data->mother_last_name = $request->input('mlastname');
        $user_data->user_phone = $request->input('phone');
        $user_data->area_id = $request->input('area_id');
        $user_data->save();

        $roles = $request->input('roles');
        foreach ($roles as $key => $item) {
            $role_user = new RoleUser();
            $role_user->user_id = $user->id;
            $role_user->role_id = $item;
            $role_user->save();
        }

        activitylog('users', 'store', null, $user->toArray());

        return redirect('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function perfil($id)
    {
        $user = User::join('user_data', 'user_data.user_id', '=' ,'users.id')
                ->join('areas', 'areas.id', '=' ,'user_data.area_id')
                ->select('users.id', 'users.email', 'users.password', 'user_data.name', 'user_data.last_name', 'user_data.mother_last_name', 'user_data.user_phone', 'user_data.area_id', 'areas.name as area')
                ->where('users.id', $id)
                ->firstOrFail();

        $areas = Area::where('enabled', 1)->get();

        return view('users.edit', compact('user', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $allowed_roles = ['superadmin', 'admin'];
        //$request->user()->authorizeRoles(['superadmin', 'admin', 'worker']);
        
        $rules = array(
            'name'        => 'string|min:3|required',
            'email'       => 'email|required|unique:users,email,'.$id,
            'password'    => 'string|min:6|nullable',
            'lastname'    => 'string|min:3|required',
            'mlastname'   => 'string|min:3|required',
            'phone'       => 'string|min:6',
            //'enabled'   => 'boolean|required',
        );
        if (in_array(\Auth::user()->roles->first()->name, $allowed_roles)) {
            array_push($rules, ['area_id'     => 'integer|required']);
        }
        $this->validate($request, $rules);

        $user = User::findOrFail($id);
        $original_data = $user->getOriginal();
        
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        //$user_data->enabled = $request->input('enabled');
        $user->save();

        $area_id = $request->input('area_id');

        $user_data = UserData::where('user_id', $id)->first();
        $user_data->name = $request->input('name');
        $user_data->last_name = $request->input('lastname');
        $user_data->mother_last_name = $request->input('mlastname');
        $user_data->user_phone = $request->input('phone');
        if ($area_id) {
            $user_data->area_id = $request->input('area_id');
        }
        $user_data->save();

        activitylog('users', 'update', $original_data, $user->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated user!');
        return redirect('home');
    }

    public function userStatus(Request $request, $user_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $rules = array(
            'status'        => 'in:0,1|required',
        );
        $this->validate($request, $rules);

        $status = $request->get('status');

        $user = User::findOrFail($user_id);
        $user->enabled = $status;
        $user->save();

        return response()->json(['data'=>json_encode($user), 'success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $user_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $user = User::findOrFail($user_id);
        $user->enabled = 0;
        $user->save();

        return response()->json(['data'=>json_encode($user), 'success'=>true]);
    }
}
