<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessStory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'story',
        'image',
        'location',
        'achievement_type',
        'amount',
        'timeframe_months',
        'is_featured',
        'is_published',
        'order',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];
}
