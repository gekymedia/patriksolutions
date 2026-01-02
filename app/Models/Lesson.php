<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lesson extends Model
{
    // 
    protected $fillable =[
        'course_id',
        'lesson_description',
        'lesson_title',
        'lesson_video',
     
    ];
    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
    use HasFactory;
}
