<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblTask extends Model
{
    use HasFactory;

    protected $table = 'tbl_task';

    protected $fillable = [
        'taskName',
        'taskDescription',
    ];

}
