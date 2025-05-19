<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($postId)
    {
        $like = Like::where('post_id', $postId)->where('usuario_id', Auth::id())->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'post_id' => $postId,
                'usuario_id' => Auth::id(),
            ]);
        }

        return redirect()->back();
    }
}
