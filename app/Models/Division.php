<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['name', 'description'];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
