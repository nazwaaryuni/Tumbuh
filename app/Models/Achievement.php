<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['member_id', 'title', 'level', 'date_achieved', 'description'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
