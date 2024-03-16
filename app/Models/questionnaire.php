<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class questionnaire extends Model
{
    use HasFactory;

    protected $fillable = ['title','expiry_date','questions'];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'datetime:Y-m-d',
        ];
    }
}
