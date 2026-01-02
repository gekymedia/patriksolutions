<?php

namespace App\Http\Controllers;

use App\Models\SuccessStory;
use Illuminate\Http\Request;

class SuccessStoryController extends Controller
{
    public function index()
    {
        $stories = SuccessStory::where('is_published', true)
            ->orderBy('is_featured', 'desc')
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('success-stories.index', compact('stories'));
    }

    public function show($id)
    {
        $story = SuccessStory::where('is_published', true)->findOrFail($id);
        $relatedStories = SuccessStory::where('is_published', true)
            ->where('id', '!=', $id)
            ->where('achievement_type', $story->achievement_type)
            ->take(3)
            ->get();
        
        return view('success-stories.show', compact('story', 'relatedStories'));
    }
}
