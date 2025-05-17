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


# Cómo sincronizar tu trabajo con Git y GitHub

## ¿Qué es `git pull` y por qué es importante?

Imagina que tú y tus amigos tienen copias del proyecto en sus computadoras. Cada uno hace cambios en su copia local (en su PC). Pero el código que está en GitHub puede cambiar porque alguno subió cosas nuevas.

**`git pull` es como decirle a tu PC: “Oye, tráeme todos los cambios nuevos que haya en GitHub para que mi copia esté al día.”**

---

## ¿Por qué usar `git pull` antes de subir tus cambios?

Si haces cambios en tu copia local y subes (`push`) sin antes actualizar tu copia con lo que hicieron los demás, puedes:

- Pisarte cambios de ellos y causar conflictos.
- Que Git te rechace el `push` porque tu copia local está "desactualizada".

Entonces:

1. **Haz `git pull` para traer los cambios que tus amigos hayan subido.**  
2. **Resuelve cualquier conflicto que pueda aparecer (si hay cambios en las mismas líneas).**  
3. **Luego haz tus cambios nuevos y súbelos con `git push`.**

---

## Comando básico para actualizar tu copia local:

```bash
git pull origin main
