<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Post extends Model
{
    protected $filleable = [
        'user_id',
        'class_id',
        'body',
        'image',
    ];

    protected $guarded = [
        'id',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function store(Request $request, $auth_id)
    {
        $user_id = $auth_id;
        if ($user_id) {
            $this->user_id = $user_id;
            $this->class_id = $request->class_id;
            $this->body = $request->body;
            $this->save();
            return true;
        }
        return false;
    }
}
