<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblScheduleTask extends Model
{
    use HasFactory;

    protected $table = 'tbl_schedule_task';

    protected $fillable = [
        'taskName',
        'taskLocation',
        'taskDate',
    ];
}
