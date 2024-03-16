<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    use HasFactory;

    public function section()
    {
        return $this->belongsTo(section::class);
    }

    public function answers()
    {
        return $this->hasMany(answer::class);
    }
}
