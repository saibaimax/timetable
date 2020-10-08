<?php

namespace App\Http\Controllers\Student;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Thread;
use App\UniversityPost;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //大学全体向け掲示板のトップページ
    public function index()
    {
        $user = Auth::user();
        $pref_id = $user->pref_id;
        $university_id = $user->university_id;
        return view('university_post.thread_menu', compact('pref_id', 'university_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //スレッド新規作成フォーム表示
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
    //スレッドの新規作成
    public function store(Request $request)
    {
        $user = Auth::user();
        $pref_id = $user->pref_id;
        $university_id = $user->university_id;
        DB::transaction(function () use ($user, $university_id, $request) {
            $thread = Thread::create([
                'university_id' => $university_id,
                'type_id' => $request->type_id,
                'user_id' => $user->id,
                'count' => 1,
                'title' => $request->title,
            ]);
            $posts = UniversityPost::create([
                'user_id' => $user->id,
                'thread_id' => $thread->id,
                'body' => 'スレッドが作成されました。',
            ]);
        });
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //ここでスレッドの一覧表示
    public function show($id)
    {
        $user = Auth::user();
        $university_id = $user->university_id;
        $threads = Thread::where([['university_id', $university_id], ['type_id', $id]])
            ->orderBy('updated_at', 'dsc')
            ->get();
        return view('university_post.thread_index', compact('university_id', 'id', 'threads'));
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
