<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Lecture;
use App\Schedule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $infos = Schedule::firstOrCreate(['user_id' => $user_id]);
        //配列の番号と時間割の番号を合わせるため、はじめにnullを入れておく
        $lecture_infos[] = null;
        for ($i = 1; $i <= 36; $i++) {
            $class_id = 'class_' . $i;
            if ($infos->$class_id != null) {
                $lecture_infos[] = Lecture::where('id', $infos->$class_id)->first();
            } else {
                $lecture_infos[] = null;
            }
        }
        return view('schedule.index', compact('lecture_infos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $day_id = $_GET['id'];
        $classes = Lecture::where('day_id', $day_id)->paginate(10);
        return view('schedule.add', compact('day_id', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $class = Lecture::find($request->id);
        ++$class->count;
        $class->save();
        $schedule = Schedule::where('user_id', Auth::id())->first();
        $class_id = 'class_' . $class->day_id;
        $schedule->$class_id = $class->id;
        $schedule->save();
        return redirect()->route('schedules.index')->with('status', '授業を登録しました');   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
