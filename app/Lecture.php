<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $table = 'classes';

    protected $filable = [
        'unibersity_id',
        'fuculty_id',
        'subject_id',
        'day_id',
        'name',
        'teacher',
        'room_number'
    ];

    protected $guarded = [
        'id'
    ];
}
