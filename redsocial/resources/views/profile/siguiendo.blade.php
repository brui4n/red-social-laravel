@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
            ➡️ <span>{{ $user->nombre }} sigue a:</span>
        </h2>

        @if($siguiendo->count())
            <ul class="space-y-4">
                @foreach($siguiendo as $seguido)
                    <li class="flex items-center gap-4 p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg transition">
                        <img class="w-12 h-12 rounded-full object-cover"
                             src="{{ $seguido->avatar ? asset('storage/' . $seguido->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($seguido->nombre) . '&color=7F9CF5&background=EBF4FF' }}"
                             alt="Avatar de {{ $seguido->nombre }}">

                        <div class="flex-1">
                            <a href="{{ route('profile.show', $seguido) }}"
                               class="text-lg font-semibold text-gray-800 hover:underline">
                                {{ $seguido->nombre }}
                            </a>
                            <p class="text-sm text-gray-500">{{ '@' . $seguido->username }}</p>
                        </div>

                        @auth
                            @if(Auth::id() !== $seguido->id)
                                <form method="POST" action="{{ route('profile.toggle-follow', $seguido) }}">
                                    @csrf
                                    <button type="submit"
                                            class="text-sm px-3 py-1 rounded-md border
                                                   {{ Auth::user()->siguiendo->contains($seguido->id) 
                                                        ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' 
                                                        : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                                        {{ Auth::user()->siguiendo->contains($seguido->id) ? 'Siguiendo' : 'Seguir' }}
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">😶 {{ $user->nombre }} aún no sigue a nadie.</p>
        @endif
    </div>
</div>
@endsection
