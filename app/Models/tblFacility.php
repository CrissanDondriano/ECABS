<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblFacility extends Model
{
    use HasFactory;
    protected $table = 'tbl_facilities';

    protected $fillable = [
        'name',
        'description',
        'image',
    ];
}
