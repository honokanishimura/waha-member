<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberHandling extends Model
{
    public $incrementing = false;

    protected $primaryKey = [
        'member_id',
        'handling_id'
    ];

    protected $fillable = [
        'member_id',
        'handling_id',
    ];
}
