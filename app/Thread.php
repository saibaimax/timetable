<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $table = 'threads';

    protected $filleable = [
        'university_id',
        'type_id',
        'user_id',
        'count',
        'title',
    ];

    protected $guarded = [
        'id',
        'deleted_at'
    ];
}
