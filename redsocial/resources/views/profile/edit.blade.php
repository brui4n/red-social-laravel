@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="border-b border-gray-200 px-6 py-4 bg-gray-50">
            <h1 class="text-2xl font-bold text-gray-900">✏️ Editar Perfil</h1>
            <p class="text-gray-600 mt-1 text-sm">Actualiza tu información personal y preferencias</p>
        </div>

        <!-- Mensajes -->
        @if (session('success'))
            <div class="mx-6 mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mx-6 mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PATCH')

            <!-- Avatar -->
            <div class="flex items-center space-x-6">
                <div>
                    <img id="avatar-preview" 
                         class="h-24 w-24 object-cover rounded-full border-4 border-gray-200" 
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nombre) . '&color=7F9CF5&background=EBF4FF' }}" 
                         alt="Avatar actual">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Foto de Perfil
                    </label>
                    <input type="file" name="avatar" id="avatar" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0 file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Formatos permitidos: JPG, PNG, GIF. Máx: 2MB</p>
                </div>
            </div>

            <!-- Datos básicos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre completo *</label>
                    <input type="text" name="nombre" id="nombre" required
                           value="{{ old('nombre', $user->nombre) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Nombre de usuario *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">@</span>
                        <input type="text" name="username" id="username" required
                               value="{{ old('username', $user->username) }}"
                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico *</label>
                <input type="email" name="email" id="email" required
                       value="{{ old('email', $user->email) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Bio -->
            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Biografía</label>
                <textarea name="bio" id="bio" rows="4" maxlength="500"
                          placeholder="Cuéntanos algo sobre ti..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bio', $user->bio) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Máximo 500 caracteres</p>
            </div>

            <!-- Info adicional -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Ubicación -->
                <div>
                    <label for="ubicacion" class="block text-sm font-medium text-gray-700 mb-1">📍 Ubicación</label>
                    <input type="text" name="ubicacion" id="ubicacion"
                           value="{{ old('ubicacion', $user->ubicacion) }}"
                           placeholder="Ciudad, País"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Sitio web -->
                <div>
                    <label for="sitio_web" class="block text-sm font-medium text-gray-700 mb-1">🌐 Sitio web</label>
                    <input type="url" name="sitio_web" id="sitio_web"
                           value="{{ old('sitio_web', $user->sitio_web) }}"
                           placeholder="https://tusitio.com"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('profile.show', $user) }}"
                   class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700
                               focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>

        <!-- Eliminar cuenta -->
        <section class="border-t border-red-200 bg-red-50 px-6 py-6 space-y-4">
            <h2 class="text-lg font-semibold text-red-700 flex items-center gap-2">
                🛑 Eliminar Cuenta
            </h2>
            <p class="text-sm text-red-600">
                Esta acción es irreversible. Tu cuenta, publicaciones y comentarios serán eliminados de forma permanente.
            </p>

            <x-danger-button
                x-data
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="bg-red-600 hover:bg-red-700"
            >
                🗑️ Eliminar Cuenta
            </x-danger-button>

            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900">
                        ¿Estás seguro de que deseas eliminar tu cuenta?
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Esta acción no se puede deshacer. Ingresa tu contraseña para confirmar.
                    </p>

                    <div class="mt-4">
                        <x-input-label for="password" value="Contraseña" class="sr-only" />
                        <x-text-input id="password" name="password" type="password"
                                      class="mt-1 block w-3/4"
                                      placeholder="Contraseña" required />
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
                        <x-danger-button class="ms-3">Eliminar cuenta</x-danger-button>
                    </div>
                </form>
            </x-modal>
        </section>
    </div>
</div>

<!-- JS para preview del avatar -->
<script>
    document.getElementById('avatar')?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (evt) {
                document.getElementById('avatar-preview').src = evt.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
