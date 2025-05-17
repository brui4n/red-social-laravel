# Guía rápida para configurar el proyecto Laravel (CodeNet)

Estas instrucciones son para que puedas poner en marcha el proyecto en tu máquina local después de clonar el repositorio.

---

## Pasos después de clonar el repositorio

```bash
# Clonar el repositorio (solo la primera vez)
git clone https://github.com/brui4n/red-social-laravel.git
cd red-social-laravel/redsocial  # Ajusta la ruta si es necesario

# Instalar las dependencias PHP con Composer
composer install

# Instalar las dependencias JS con npm o yarn
npm install

# Copiar el archivo de configuración de entorno
cp .env.example .env

# Generar la clave de la aplicación Laravel
php artisan key:generate

# Crear la base de datos local (hacer esto en tu gestor preferido)

# Ejecutar migraciones para crear las tablas necesarias
php artisan migrate

# (Opcional) Ejecutar seeders para datos de prueba si existen
php artisan db:seed

# Compilar los assets (CSS/JS)
npm run dev

# Levantar el servidor local para pruebas
php artisan serve
