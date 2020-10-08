<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UniversityPost extends Model
{
    protected $table = 'university_posts';

    protected $filleable = [
        'user_id',
        'thread_id',
        'body',
        'image_path',
    ];

    protected $guarded = [
        'id',
        'deleted_at'
    ];
}
