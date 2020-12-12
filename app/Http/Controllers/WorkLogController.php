<?php

namespace App\Http\Controllers;

use App\Models\WorkLog;
use Illuminate\Http\Request;

class WorkLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$request->user()->authorizeRoles(['superadmin', 'admin']);

        $rules = [
            'work_id' => 'required',
            //'user_id' => 'required',
            'type' => 'required',
        ];

        $this->validate($request, $rules);

        $user_id = \Auth::user()->id;
        $type = $request->input('type');

        if ($type == 'start') {
            $description = "Empezó la tarea";
        } elseif ($type = 'pause') {
            $description = "Pausó la tarea";
        } elseif ($type = 'stop') {
            $description = "Terminó la tarea";
        }

        $work_log = new WorkLog();
        $work_log->work_id = $request->input('work_id');
        //$work_log->user_id = $request->input('user_id');
        $work_log->user_id = $user_id;
        $work_log->type = $type;
        $work_log->description = $description;
        $work_log->save();

        $work_logs = WorkLog::where('user_id', $user_id)
                    ->get();

        activitylog('work_log', 'store', null, $work_log->toArray());

        return response()->json(['success'=>true, 'data'=>json_encode($work_logs)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Log $log)
    {
        //
    }
}
