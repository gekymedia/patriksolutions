<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'answers',
        'current_stage',
        'recommended_milestone',
        'personalized_plan',
        'score',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
