<?php

namespace App\Http\Controllers;

use App\Models\WorkLog;
use App\Models\OtWork;
use App\Models\OtWorkReason;
use App\Models\WorkAdditionalInformationData;
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
     * @param  \App\Models\WorkLog  $log
     * @return \Illuminate\Http\Response
     */
    public function show(WorkLog $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkLog  $log
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkLog $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkLog  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OtWork $log)
    {
        $comments = $request->get('comments');

        $log->comments = $comments;
        $log->save();

        return response()->json(['data'=>json_encode($log->comments),'success'=>true]);
    }
    public function update_coldata(Request $request)
    {
        $coldata = $request->get('coldata');

        $old_workaddinfo_data = WorkAdditionalInformationData::
                join('work_additional_information_cols', 'work_additional_information_cols.id', '=', 'work_additional_information_data.col_id')
                ->select('work_additional_information_data.*', 'work_additional_information_cols.work_add_info_id')
                ->where('work_additional_information_data.ot_work_id', $coldata[1]['ot_work_id'])
                ->where('work_additional_information_cols.work_add_info_id', $coldata[1]['work_add_info_id'])
                ->delete()
        ;
        $set_workaddinfo_data = [];

        foreach ($coldata as $key => $data) {
            //$name = preg_split('/\\] \\[|\\[|\\]/', $data, -1, PREG_SPLIT_NO_EMPTY);
            $work_addinfo_data = new WorkAdditionalInformationData();
            $work_addinfo_data->col_id = $data['col_id'];
            $work_addinfo_data->ot_work_id = $data['ot_work_id'];
            $work_addinfo_data->row = $data['row'];
            $work_addinfo_data->content = $data['content'];
            $work_addinfo_data->save();

            $set_workaddinfo_data[] = $work_addinfo_data;
        }

        return response()->json(['data'=>json_encode($set_workaddinfo_data),'success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkLog  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkLog $log)
    {
        //
    }
}
