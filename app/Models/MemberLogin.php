<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberLogin extends Model
{

    protected $fillable = [
        'member_id',
        'ip',
    ];

}
