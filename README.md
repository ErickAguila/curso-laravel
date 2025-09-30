<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre este proyecto

Este es un proyecto práctico del curso de PHP con Laravel, donde se verá los siguientes puntos

* PHP 8.2
* Laravel
* Crear aplicaciones Backend
* Conceptos del Backend
* Autenticación con JWT
* Programación Orientada a Objetos
* Programación Funcional
* Conceptos de Arquitectura de Software
* Reglas de negocio
* Manejo de Middlewares
* Manejo de Logs y Caché
* Tareas en segundo plano
* Pruebas

### Pasos para correr este proyecto
```
# Instalar las dependecias de composer
composer install

# Instalar las dependencias de frontend
npm i

# Correr proyecto
php artisan serve
```


### Comandos básicos

```
# Crear un nuevo controlador
php artisan make:controller NOMBRE_CONTROLADOR

# Crear un modelo
php artisan make:model NOMBRE_MODELO

# Crear un nuevo request
php artisan make:request UpdateProductRequest

# Crear un middleware
php artisan make:middleware CheckValueInHeader

```

### Manejo de base de datos

```
# Crear migración
php artisan make:migration create_product_table

# Subir o correr migración
php artisan migrate

# Actualizar tabla con migraciones
php artisan make:migration add_price_to_product_table --table=product

# Revertir la última migración
php artisan migrate:rollback

# Eliminar todas las migraciones
php artisan migrate:reset

```

### Levantar base de datos con Docker

```
docker-compose up -d

php artisan migrate
```