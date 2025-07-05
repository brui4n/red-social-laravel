import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Alpine = Alpine;
Alpine.start();

// Configurar Pusher con Laravel Echo
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    wsHost: 'ws-' + import.meta.env.VITE_PUSHER_APP_CLUSTER + '.pusher.com',
    wsPort: 443,
    disableStats: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    },
});

console.log('🛰 Echo conectado como usuario ID:', window.Laravel?.userId);

if (window.Laravel?.userId) {
    window.Echo.private(`notificaciones.${window.Laravel.userId}`)
        .listen('.nueva-notificacion', (data) => {
            console.log('🔔 Notificación en tiempo real:', data);

            const toast = document.createElement('div');
            toast.className = 'fixed top-5 right-5 bg-blue-500 text-white px-4 py-2 rounded shadow-lg z-50 animate-fade-in-out';
            toast.textContent = `${data.usuario}: ${data.mensaje}`;
            document.body.appendChild(toast);

            setTimeout(() => toast.remove(), 3000);
        })
        .error((error) => {
            console.error('❌ Error al conectar al canal privado:', error);
        });
}
