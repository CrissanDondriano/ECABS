<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblTaskLocation extends Model
{
    use HasFactory;

    protected $table = 'tbl_task_location';

    protected $fillable = [
        'locationName',
    ];
}
