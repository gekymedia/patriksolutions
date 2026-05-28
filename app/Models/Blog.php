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

    public function getThumbnailUrlAttribute(): ?string
    {
        if (empty($this->blog_thumbnail)) {
            return null;
        }

        $thumbnail = $this->blog_thumbnail;

        if (str_starts_with($thumbnail, 'http://') || str_starts_with($thumbnail, 'https://')) {
            return $thumbnail;
        }

        $path = ltrim($thumbnail, '/');

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        return asset('storage/' . $path);
    }
}
