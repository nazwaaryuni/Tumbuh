<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'item_name',
        'planned_amount',
        'actual_amount',
        'receipt_url',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
