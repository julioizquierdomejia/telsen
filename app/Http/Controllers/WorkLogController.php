<?php

namespace App\Http\Controllers;

use App\Models\WorkLog;
use App\Models\OtWorkReason;
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
        $reason = $request->input('reason');

        if ($type == 'start') {
            $ot_reason = OtWorkReason::where('code', 'start')->first();
            if ($ot_reason) {
                $reason = $ot_reason->id;
            }
            $description = "Empezó la tarea.";
        } elseif ($type == 'pause') {
            $description = "Pausó la tarea.";
        } elseif ($type == 'continue') {
            $ot_reason = OtWorkReason::where('code', 'continue')->first();
            if ($ot_reason) {
                $reason = $ot_reason->id;
            }
            $description = "Continuó la tarea.";
        } elseif ($type == 'end') {
            $ot_reason = OtWorkReason::where('code', 'end')->first();
            if ($ot_reason) {
                $reason = $ot_reason->id;
            }
            $description = "Finalizó la tarea.";
        } elseif ($type == 'restart') {
            $ot_reason = OtWorkReason::where('code', 'restart')->first();
            if ($ot_reason) {
                $reason = $ot_reason->id;
            }
            $description = "Se reinició la tarea.";
        }

        $work_log = new WorkLog();
        $work_log->work_id = $request->input('work_id');
        //$work_log->user_id = $request->input('user_id');
        $work_log->user_id = $user_id;
        $work_log->type = $type;
        $work_log->description = $description;
        $work_log->reason_id = $reason;
        $work_log->save();

        $work_logs = WorkLog::join('ot_work_reasons', 'ot_work_reasons.id', '=', 'work_logs.reason_id')
                    ->select('work_logs.*', 'ot_work_reasons.name as reason')
                    ->where('user_id', $user_id)
                    ->where('work_id', $work_log->work_id)
                    ->orderBy('id', 'desc')
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
