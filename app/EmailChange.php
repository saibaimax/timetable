<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailChange extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'user_id', 'email', 'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}