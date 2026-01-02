<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'milestone_type',
        'title',
        'description',
        'target_amount',
        'current_amount',
        'target_date',
        'completed_at',
        'is_completed',
        'order',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'target_date' => 'date',
        'completed_at' => 'date',
        'is_completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
