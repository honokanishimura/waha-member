<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLogin extends Model
{
    protected $fillable = [
        'admin_id',
        'ip',
    ];
}
