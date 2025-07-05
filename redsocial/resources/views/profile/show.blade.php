@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">
    <!-- Perfil Header -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <img class="w-32 h-32 rounded-full object-cover border-4 border-gray-200" 
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nombre) . '&color=7F9CF5&background=EBF4FF' }}" 
                         alt="{{ $user->nombre }}">
                </div>

                <!-- Información del Usuario -->
                <div class="flex-1 space-y-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $user->nombre }}</h1>
                        @if($user->username)
                            <p class="text-gray-600">{{ '@' . $user->username }}</p>
                        @endif
                    </div>

                    @if($user->bio)
                        <p class="text-lg text-gray-700">{{ $user->bio }}</p>
                    @endif

                    <!-- Info adicional -->
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                        @if($user->ubicacion)
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $user->ubicacion }}</span>
                            </div>
                        @endif

                        @if($user->sitio_web)
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5a4 4 0 00-5.656-5.656l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
                                </svg>
                                <a href="{{ $user->sitio_web }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{ str_replace(['http://', 'https://'], '', $user->sitio_web) }}
                                </a>
                            </div>
                        @endif

                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            <span>Se unió en {{ $user->created_at->format('F Y') }}</span>
                        </div>
                    </div>

                    <!-- Estadísticas -->
                    <div class="flex gap-6">
                        <div class="text-center">
                            <div class="font-bold text-xl">{{ $estadisticas['posts_count'] ?? 0 }}</div>
                            <div class="text-sm text-gray-600">Posts</div>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('profile.seguidores', $user) }}" class="text-blue-600 hover:underline">
                                <div class="font-bold text-xl">{{ number_format($estadisticas['seguidores_count'] ?? 0) }}</div>
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

                    <!-- Acciones -->
                    <div class="flex gap-2">
                        @if(Auth::check() && Auth::id() === $user->id)
                            <a href="{{ route('profile.edit') }}" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">
                                ⚙️ Editar Perfil
                            </a>
                        @elseif(Auth::check())
                            <form method="POST" action="{{ route('profile.toggle-follow', $user) }}">
                                @csrf
                                <button type="submit" 
                                        class="px-4 py-2 {{ $estaSiguiendo ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-blue-600 text-white hover:bg-blue-700' }} rounded-md transition-colors">
                                    {{ $estaSiguiendo ? 'Siguiendo' : 'Seguir' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts recientes -->
    <div class="bg-white rounded-lg shadow-md">
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

    <!-- Likes dados -->
    @if($user->liked_posts->count())
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">❤️ Posts que le gustaron</h2>
                <div class="space-y-4">
                    @foreach($user->liked_posts as $post)
                        <div class="p-4 border border-blue-100 rounded-lg bg-blue-50 shadow-sm">
                            <div class="flex justify-between items-center">
                                <h3 class="font-semibold text-blue-800 text-lg">{{ $post->titulo }}</h3>
                                <span class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 mt-2 text-sm">{{ Str::limit($post->contenido, 100) }}</p>
                            <a href="{{ route('posts.show', $post) }}" class="text-sm text-blue-600 hover:underline mt-2 inline-block">
                                Ver publicación
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Comentarios realizados -->
    @if($user->comentarios->count())
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">💬 Comentarios realizados</h2>
                <div class="space-y-4">
                    @foreach($user->comentarios as $comentario)
                        <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                            <div class="flex items-start gap-2">
                                <div class="text-2xl">💬</div>
                                <div class="flex-1">
                                    <p class="text-gray-800 text-sm">"{{ $comentario->contenido }}"</p>
                                    <a href="{{ route('posts.show', $comentario->post) }}" 
                                       class="text-xs text-blue-500 hover:underline block mt-1">
                                        En: {{ $comentario->post->titulo ?? 'Publicación eliminada' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
