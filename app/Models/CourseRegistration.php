<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{
    //
    protected $fillable = [
        'course_id',
        'user_id',
        'payment_status',
        // 'lesson_video',
    ];
    public function course (){
        return $this->belongsTo(Course::class,'course_id');
    }
    public function user (){
        return $this->belongsTo(User::class,'user_id');
    }
    use HasFactory;
}
