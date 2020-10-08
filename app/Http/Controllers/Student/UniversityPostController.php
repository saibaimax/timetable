<?php

namespace App\Http\Controllers\Student;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Thread;
use App\UniversityPost;

class UniversityPostController extends Controller
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
    //ここで新規投稿
    public function store(Request $request)
    {
        $university_post = new UniversityPost;
        //投稿内容required validation
        if ($request->file('image')) {
            $img = Image::make($request->image);
            $img_path = 'unipedia_' . uniqid() . '.jpg';
            $img->resize(300, 300)->save(storage_path() . '/app/public/post_board_img/' .  $img_path);
            $university_post->image_path = $img_path;
            $result = true;
        } else {
            $university_post->body = $request->body;
            $result = false;
        }
        $university_post->user_id = Auth::id();
        $university_post->thread_id = $request->thread_id;
        $university_post->save();
        return redirect()->back()
            ->with($result === true ? 'message' : 'error', $result === true ? '画像を投稿しました' : '投稿しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //スレッド内の投稿一覧
    public function show($id)
    {
        $thread = Thread::find($id);
        ++$thread->count;
        $thread->save();
        $posts = UniversityPost::where('thread_id', $id)
            ->orderBy('created_at', 'dsc')
            ->get();
        return view('university_post.post_index', compact('thread', 'posts'));
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
