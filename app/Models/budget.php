<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class budget extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'month','year', 'incomes', 'expenses', 'personal', 'food', 'lifestyle'];

    protected $casts = [
        'incomes' => 'array',
        'expenses' => 'array',
        'personal' => 'array',
        'food' => 'array',
        'lifestyle' => 'array',
    ];
}
