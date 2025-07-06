@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-8">
    {{-- Perfil --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden p-6">
        <div class="flex flex-col md:flex-row gap-6">
            {{-- Avatar --}}
            <div class="flex-shrink-0 text-center md:text-left">
                <img class="w-32 h-32 rounded-full object-cover border-4 border-gray-200" 
                     src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nombre) . '&color=7F9CF5&background=EBF4FF' }}" 
                     alt="{{ $user->nombre }}">
            </div>

            {{-- Info del usuario --}}
            <div class="flex-1 space-y-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $user->nombre }}</h1>
                    @if($user->username)
                        <p class="text-gray-600">{{ '@' . $user->username }}</p>
                    @endif
                </div>

                @if($user->bio)
                    <p class="text-gray-700 text-base">{{ $user->bio }}</p>
                @endif

                <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                    @if($user->ubicacion)
                        <div class="flex items-center gap-1">
                            📍<span>{{ $user->ubicacion }}</span>
                        </div>
                    @endif

                    @if($user->sitio_web)
                        <div class="flex items-center gap-1">
                            🔗
                            <a href="{{ $user->sitio_web }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ str_replace(['http://', 'https://'], '', $user->sitio_web) }}
                            </a>
                        </div>
                    @endif

                    <div class="flex items-center gap-1">
                        📅 <span>Se unió en {{ $user->created_at->format('F Y') }}</span>
                    </div>
                </div>

                <div class="flex gap-6 mt-2">
                    <div class="text-center">
                        <div class="font-bold text-xl">{{ $estadisticas['posts_count'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Posts</div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('profile.seguidores', $user) }}" class="text-blue-600 hover:underline">
                            <div class="font-bold text-xl">{{ $estadisticas['seguidores_count'] ?? 0 }}</div>
                            <div class="text-sm">Seguidores</div>
                        </a>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('profile.siguiendo', $user) }}" class="text-blue-600 hover:underline">
                            <div class="font-bold text-xl">{{ $estadisticas['siguiendo_count'] ?? 0 }}</div>
                            <div class="text-sm">Siguiendo</div>
                        </a>
                    </div>
                </div>

                <div class="mt-4">
                    @if(Auth::id() === $user->id)
                        <a href="{{ route('profile.edit') }}" 
                           class="inline-block px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition">
                            ⚙️ Editar Perfil
                        </a>
                    @elseif(Auth::check())
                        <form method="POST" action="{{ route('profile.toggle-follow', $user) }}">
                            @csrf
                            <button type="submit" 
                                    class="px-4 py-2 {{ $estaSiguiendo ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-blue-600 text-white hover:bg-blue-700' }} rounded transition">
                                {{ $estaSiguiendo ? 'Siguiendo' : 'Seguir' }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Posts recientes --}}
    <div class="bg-white rounded-xl shadow border">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">📝 Posts Recientes</h2>
            @if($user->posts->count())
                <div class="space-y-4">
                    @foreach($user->posts as $post)
                        <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                            <h3 class="font-semibold text-gray-800 text-lg">{{ $post->titulo }}</h3>
                            <p class="text-gray-600 mt-1">{{ Str::limit($post->contenido, 150) }}</p>
                            <div class="flex items-center justify-between mt-2 text-sm text-gray-500">
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                                <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline">
                                    Ver más
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-4">
                    {{ Auth::id() === $user->id ? 'Aún no has publicado nada.' : $user->nombre . ' no ha publicado nada aún.' }}
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
