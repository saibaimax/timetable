<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterSchoolController extends Controller
{
    public function selectPref(Request $request)
    {
        $prefs = config('prefs');
        return view('auth.register_pref', compact('prefs'));
    }

    public function selectUniversity(Request $request)
    {
        $pref_id = $request->pref_id;
        if (config($pref_id)) {
            $schools = config($pref_id);
            $request->session()->put('pref_id', $pref_id);
        } else {
            return back()->with('error', '存在しない県です。');   
        }
        return view('auth.register_university', compact('schools'));
    }

    public function selectFuculty(Request $request)
    {
        $pref_id = $request->session()->get('pref_id');
        $university_id = $request->university_id;
        $fuculties = config($pref_id . "." . $university_id);
        if ($fuculties) {
            $request->session()->put('university_id', $university_id);
        } else {
            return back()->with('error', '大学が存在しません。');   
        }
        return view('auth.register_fuculty', compact('fuculties'));
    }

    public function selectClass(Request $request)
    {
        $fuculty_id = $request->fuculty_id;
        $pref_id = $request->session()->get('pref_id');
        $university_id = $request->session()->get('university_id');
        $classes = config($pref_id . "." . $university_id . ".class." . $fuculty_id);
        if (!empty($classes)) {
            $request->session()->forget('root');
            $request->session()->put('fuculty_id', $fuculty_id);
        } else {
            return back()->with('error', '学部が存在しません。'); 
        }
        return view('auth.register_class', compact('classes'));
    }

}
