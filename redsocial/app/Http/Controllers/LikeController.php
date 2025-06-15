<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($postId)
    {
        $like = Like::where('post_id', $postId)
                    ->where('user_id', Auth::id()) // <- CAMBIO AQUÍ
                    ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'post_id' => $postId,
                'user_id' => Auth::id(), // <- CAMBIO AQUÍ
            ]);
        }

        return redirect()->back();
    }
}
