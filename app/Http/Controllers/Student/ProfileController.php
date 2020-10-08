<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailChange;
use App\EmailChange;
use App\User;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(
        User $user,
        EmailChange $emailChange
    )
    {
        $this->user = $user;
        $this->emailChange = $emailChange;
    }

    public function index()
    {
        $user = $this->user->find(Auth::id());
        return view('profile.index', compact('user'));
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
    public function store(ProfileRequest $request)
    {
        $profile = $this->user->find(Auth::id());
        $profile->name = $request->name;

        if (Hash::check($request->oldpass, $profile->password)) {
            $profile->password = Hash::make($request->oldpass);

            if (!empty($request->newpass)) {
                $profile->password = Hash::make($request->newpass);
            }

            if ($profile->email != $request->email) {
                DB::transaction(function () use ($request, $profile) {
                    $to = $request->email;
                    $token = hash_hmac('sha256', str_random(40) . $request->email, env('APP_KEY'));
                    Mail::to($to)->send(new MailChange($token));
                    EmailChange::updateOrCreate([
                        'user_id' => Auth::id()
                    ], [
                        'email' => $request->email,
                        'token' => $token
                    ]);
                    $profile->save();
                });
                return redirect()->back()
                    ->with(
                        'status', 
                        'プロフィールを変更しました。メールアドレスを変更した場合は変更後のメールアドレスを確認して認証してください'
                    );
            }
            $profile->save();
        } else {
            return redirect()->back()
                ->with('error', 'パスワードが一致しません');
        }
        return redirect()->back()
            ->with('status', 'プロフィールを変更しました。');
    }

    public function authorizeEmail($token)
    {
        $profile = $this->emailChange
            ->where('token', $token)
            ->first();
        if ($profile) {
            DB::transaction(function () use ($profile) {
                $user = $this->user->find(Auth::id());
                $user->email = $profile->email;
                $user->save();
                $profile->delete();
            });
            return redirect()->back()
                ->with('status', 'プロフィールを変更しました。');
        }
        return redirect()
            ->route('profile.index')
            ->with('error', 'プロフィールの変更に失敗しました');
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
