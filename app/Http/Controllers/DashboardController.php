<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isCreator()) {
            // Creator sees their uploaded photos
            $photos = Photo::where('user_id', $user->id)
                ->withCount('comments', 'ratings')
                ->latest()
                ->paginate(12);
            
            return view('dashboard.creator', compact('photos'));
        } else {
            $photos = Photo::with('user')
                ->withCount('comments', 'ratings')
                ->latest()
                ->paginate(12);
            
            return view('dashboard.consumer', compact('photos'));
        }
    }
}