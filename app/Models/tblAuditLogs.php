<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblAuditLogs extends Model
{
    protected $fillable = [
        // other fields...
        'userId',
        'type',
        'description'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    use HasFactory;
}
