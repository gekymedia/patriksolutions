<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;
    protected $fillable =[
        'blog_title',
        'blog_content',
        'blog_author',
        'blog_thumbnail',
        'blog_slug',
        'blog_status',
        'blog_view',
        'created_at',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($blog) {
            $blog->blog_slug = Str::slug($blog->blog_title); // Generate slug from title
        });
    }
}
