<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Mostrar el perfil público de un usuario
     */
    public function show(User $user): View
    {
        $user->load([
            'posts' => function ($query) {
                $query->latest();
            },
            'liked_posts',
            'comentarios'
        ]);

        $estadisticas = $user->estadisticas();
        $estaSiguiendo = false;

        if (Auth::check()) {
            $estaSiguiendo = Auth::user()->estaSiguiendo($user);
        }

        return view('profile.show', compact('user', 'estadisticas', 'estaSiguiendo'));
    }

    /**
     * Seguir o dejar de seguir a un usuario
     */
    public function toggleFollow(User $user): RedirectResponse
    {
        $currentUser = Auth::user();

        if ($currentUser->id === $user->id) {
            return back()->with('error', 'No puedes seguirte a ti mismo');
        }

        $ahoraSigue = $currentUser->alternarSeguimiento($user);
        $mensaje = $ahoraSigue 
            ? "Ahora sigues a {$user->nombre}"
            : "Has dejado de seguir a {$user->nombre}";

        return back()->with('success', $mensaje);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Actualizar campos básicos
        $user->fill($request->validated());
        
        // 🖼️ Manejar avatar si se subió
        if ($request->hasFile('avatar')) {
            // Eliminar avatar anterior si existe
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Guardar nuevo avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
        
        // Si el email cambió, marcar como no verificado
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        
        $user->save();
        
        return Redirect::route('profile.edit')->with('success', '¡Perfil actualizado correctamente! 🎉');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    /**
    * Mostrar lista de seguidores del usuario
    */
    public function seguidores(User $user): View
    {
        $seguidores = $user->seguidores()->with('posts')->get();
        return view('profile.seguidores', compact('user', 'seguidores'));
    }

    /**
    * Mostrar lista de usuarios que sigue
    */
    public function siguiendo(User $user): View
    {
        $siguiendo = $user->siguiendo()->with('posts')->get();
        return view('profile.siguiendo', compact('user', 'siguiendo'));
    }

    public function postsQueMeGustaron()
    {
        $user = Auth::user();
        $likedPosts = $user->liked_posts()->with('user')->latest()->paginate(10);

        return view('profile.posts_que_me_gustaron', [
            'posts' => $likedPosts
        ]);
    }

    public function misComentarios()
    {
        $user = Auth::user();
        $comentarios = $user->comentarios()->with('post')->latest()->paginate(10);

        return view('profile.mis_comentarios', [
            'comentarios' => $comentarios
        ]);
    }



}
