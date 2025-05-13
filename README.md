# ProyectoLaravel

## Descripción del proyecto

ProyectoLaravel es una aplicación web desarrollada con el framework PHP [Laravel](https://laravel.com/) que tiene como objetivo principal ilustrar y practicar las buenas prácticas en el desarrollo de aplicaciones MVC. A lo largo del curso, hemos implementado funcionalidades clave como:

* Gestión de usuarios y roles (registro, inicio de sesión, permisos).
* Operaciones CRUD (Crear, Leer, Actualizar, Eliminar) sobre entidades de ejemplo.
* Validación de formularios y manejo de errores.
* Autenticación y autorización mediante middleware.
* Estructuración de vistas con Blade y uso de componentes.
* Conexión a base de datos MySQL y uso de migraciones.
* Integración básica de pruebas unitarias y funcionales.

El propósito de este proyecto es servir como guía práctica para entender el flujo de trabajo en un proyecto Laravel real y sentar las bases para desarrollos más avanzados.

## Pasos generales del desarrollo

A continuación se describe de forma resumida el proceso que hemos seguido desde el inicio del proyecto hasta su estado actual:

1. **Recolección de requisitos y planificación**

   * Definimos el alcance y las funcionalidades principales.
   * Establecimos roles de equipo y calendario de entregas.

2. **Configuración del entorno de desarrollo**

   * Instalación de PHP, Composer, servidor web (Apache/Nginx) y MySQL.
   * Creación del proyecto con `composer create-project --prefer-dist laravel/laravel ProyectoLaravel`.
   * Configuración de variables de entorno en el archivo `.env`.

3. **Estructura inicial y control de versiones**

   * Creación de repositorio Git y primeros commits.
   * Definición de ramas (por ejemplo, `main`, `develop`, `feature/*`).

4. **Modelado de la base de datos**

   * Diseño del esquema en MySQL.
   * Creación de migraciones con Artisan (`php artisan make:migration`).
   * Definición de relaciones entre modelos (One-to-Many, Many-to-Many).

5. **Desarrollo de funcionalidad núcleo**

   * Implementación de controladores, modelos y rutas.
   * Creación de vistas Blade para formularios y listados.
   * Validación de datos con `FormRequest`.

6. **Autenticación y autorización**

   * Instalación de Laravel Breeze/Jetstream u otro paquete de autenticación.
   * Configuración de middleware y políticas (Policies).

7. **Pruebas y depuración**

   * Redacción de pruebas unitarias con PHPUnit (`php artisan make:test`).
   * Pruebas funcionales con Laravel Dusk o HTTP tests.
   * Solución de errores y refactorización de código.

8. **Documentación y comentarios**

   * Redacción de comentarios en controladores y modelos.
   * Actualización de este archivo README con instrucciones de uso.

9. **Despliegue**

   * Preparación del entorno de producción (servidores, variables de entorno).
   * Ejecución de migraciones y seeds (`php artisan migrate --seed`).
   * Configuración de tareas programadas y colas si fuese necesario.

10. **Mantenimiento y mejoras futuras**

    * Planificación de nuevas funcionalidades.
    * Optimización de rendimiento y seguridad.
    * Actualización de dependencias.
   
  **Link Pagina:** https://gymprojectds.infinityfreeapp.com/ 
  **Información Adicional:** https://deepwiki.com/solerdidac/FinalProject/3.1-models-and-database 

