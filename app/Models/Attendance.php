<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'member_id',
        'time',
        'status',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
