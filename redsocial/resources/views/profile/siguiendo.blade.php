@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <h2 class="text-2xl font-bold mb-4">➡️ {{ $user->nombre }} sigue a:</h2>

        @if($siguiendo->count())
            <ul class="space-y-4">
                @foreach($siguiendo as $seguido)
                    <li class="flex items-center gap-4 p-3 border rounded-lg">
                        <img class="w-12 h-12 rounded-full object-cover"
                             src="{{ $seguido->avatar ? asset('storage/' . $seguido->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($seguido->nombre) . '&color=7F9CF5&background=EBF4FF' }}"
                             alt="Avatar">

                        <div class="flex-1">
                            <a href="{{ route('profile.show', $seguido) }}" class="font-semibold text-gray-800 hover:underline">
                                {{ $seguido->nombre }}
                            </a>
                            <p class="text-sm text-gray-600">{{ '@' . $seguido->username }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">{{ $user->nombre }} aún no sigue a nadie.</p>
        @endif
    </div>
</div>
@endsection
