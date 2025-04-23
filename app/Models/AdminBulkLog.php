<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminBulkLog extends Model
{
    protected $fillable = [
        'admin_id',
        'ip',
        'action',
    ];
}
