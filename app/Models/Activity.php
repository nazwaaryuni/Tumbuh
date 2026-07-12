<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'name',
        'start_date',
        'end_date',
        'location',
        'status',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function budgets()
    {
        return $this->hasMany(ExpenseBudget::class);
    }
}
