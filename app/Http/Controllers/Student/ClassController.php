<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ClassAddRequest;
use App\Http\Requests\ClassPostRequest;
use App\Schedule;
use App\Lecture;
use App\Post;
use DB;
use Image;
use phpDocumentor\Reflection\Types\Null_;

class ClassController extends Controller
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
    public function store(ClassPostRequest $request, Post $post)
    {
        if (!$request->body && !$request->image) {
            return redirect()->back()
                ->with('error', '投稿に失敗しました');
        }

        //投稿内容required validation
        if ($request->image) {
            $img = Image::make($request->image);
            $img_path = 'unipedia_' . uniqid() . '.jpg';
            $img->resize(300, 300)->save(storage_path() . '/app/public/post_board_img/' .  $img_path);
            $post->image_path = $img_path;
            $result = true;
        }

        if ($request->body) {
            $post->body = $request->body;
            $result = true;
        }

        $post->user_id = Auth::id();
        $post->class_id = $request->class_id;
        $post->save();
        return redirect()->back()
            ->with('message', '投稿しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = Auth::id();
        $user_name = Auth::user()->name;
        $schedule = Schedule::where('user_id', $user_id)->first();
        $class_id = 'class_' . $id;
        $schedule_id = $schedule->$class_id;
        $lecture = Lecture::where('id', $schedule_id)->first();
        $posts = Post::with('user')
            ->where('class_id', $id)
            ->orderBy('created_at', 'dsc')
            ->paginate(10);
        $exist_check = Schedule::where('user_id', $user_id)
            ->where($class_id, $lecture->id)
            ->get();
        return view('schedule.detail', compact('id', 'exist_check', 'lecture', 'posts'));
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
    //授業登録時に時間割表も更新する
    public function update(ClassAddRequest $request, $id)
    {
        $user_info = Auth::user();
        //授業情報関係 //classesテーブル
        $lecture = Lecture::updateOrCreate([
            'university_id' => $user_info->university_id,
            'fuculty_id' => $user_info->fuculty_id,
            'subject_id' => $user_info->subject_id,
            'name' => $request->name,
            //$idは何曜何限かの情報
            'day_id' => $id,
        ], [
            'teacher' => $request->teacher,
            'room_number' => $request->room_number
        ]);
        $lecture_id = $lecture->id;
        $day_id = $lecture->day_id;
        //ユーザーの時間割表更新
        $schedule = Schedule::where('user_id', $user_info->id)->first();
        $class_id = 'class_' . $day_id;
        $schedule->$class_id = $lecture_id;
        $schedule->save();

        return redirect()->route('schedules.index')
            ->with('status', '授業を登録しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Auth::id();
        $class_id = 'class_' . $id;
        $user_schedule = Schedule::where('user_id', $user_id)->first();
        $user_schedule->$class_id = NULL;
        $user_schedule->save();
        return redirect()->route('schedules.index')
            ->with('status', '更新しました');
    }
}
