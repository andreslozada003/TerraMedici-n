# TerraMedición

Plataforma corporativa y CMS para topografía e ingeniería, construida sobre Laravel 12.

## Instalación local

1. Configure MySQL en `.env` (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
2. Ejecute `php artisan key:generate`, `php artisan migrate` y `php artisan db:seed`.
3. Cree el enlace público para archivos: `php artisan storage:link`.
4. Ejecute `php artisan serve`.

El seeder crea el acceso demostrativo `admin@terramedicion.test` con clave `Cambiar123!`. Cámbiela antes de cualquier uso real.

## Despliegue seguro

Antes de desplegar, haga una copia de seguridad de la base y de `storage/app/public`. En el servidor ejecute únicamente `php artisan migrate --force` después de revisar migraciones pendientes; nunca use `migrate:fresh`. Configure `APP_ENV=production`, `APP_DEBUG=false`, HTTPS y una clave de aplicación propia.

## Operación del contenido

Use el panel `/admin` para crear servicios, proyectos o noticias. Cada alta inserta un registro nuevo; archivar usa eliminación lógica y no borra archivos existentes. Los estados disponibles son borrador, publicado y archivado.
