<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class LikeController extends Controller
{
    public function toggle($postId)
    {
        $user = Auth::user();
        $post = Post::findOrFail($postId);

        if ($user->liked_posts()->where('post_id', $postId)->exists()) {
            $user->liked_posts()->detach($postId);
        } else {
            $user->liked_posts()->attach($postId);
        }

        return redirect()->back();
    }
}
