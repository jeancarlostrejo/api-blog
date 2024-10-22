<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Api Blog

## Descripción

Api que permite a los usuarios registrarse, y una ves registrados y logueados podrán crear, listar, editar y eliminar publicaciones; también pueden comentar las publicaciones, así como también permite darle "me gusta" a las publicaciones de otros usuarios y subscribirse a éstos para que cuando suban una nueva publicación, les llegue una notificacion por correo notificandoles de la creación.

## Funcionalidades 
+ Los usuarios pueden registrarse y loguearse (recibiran un token de acceso al loguearso, el cual les permitirá interactuar con la api)
+ Los usuarios pueden hacer operaciones crud sobre sus publicaciones.
+ Las publicaciónes tienen los siguientes campos:
    - title: El título del post.
    - Descripción: Una descripción de la tarea.
    - content: el contenido de la publicación.
    - image: una imagen.
    - Category_id: categoría que se le quiera dar a la publicación (clave foránea que hace referencia a una tabla donde están las categorías).
+ Los usuarios pueden comentar las publicaciones.
+ Los usuarios pueden darle "me gusta" a las publicaciones.
+ Los usuarios pueden quitar el "me gusta" a las publicaciones.
+ Los usuarios pueden subscribirse a otros usuarios para que se les notifique via email cuando se cree una nueva publicación.
+ Los usuarios pueden desuscribirse de los usuarios.
+ Permite ver los subscriptores de un usuarios.
+ Permite ver las subscripciones que tiene un usuarios.

## Reglas de negocio
+ Solo los usuarios registrados pueden tener acceso a las funcionalidades.
+ Los usuarios registrados pueden hacer operaciones crud sobre sus publicaciones.
+ Los usuarios pueden comentar publicaciones, y solo pueden eliminar comentarios los usuarios que los crearon o el creador del post donde se comentó.
+ Los usuarios pueden dar "me gusta" a las publicaciones una vez (dos veces significaría quitar el "me gusta").
+ Los usuarios pueden subscribirse a otros usuarios (no puedes subscribirte dos veces a un usuario).
+ Para desuscribirte de un usuario, primero tienes que haber estado suscrito a él.
+ Un usuario no puede subscribirse a él mismo.

## Pasos para ejecutar el proyecto
1. Descarga o clona el proyecto
2. Ejecuta el comando **`composer install`**
4. Copia en archivo **.env.example** y renombralo a **.env**
5. Edita las variables de entorno para la conexión a la base de datos y configuracion del servidor de correo. (Cambia el valor de la variable QUEUE_CONNECTION por database)
6. Ejecuta el comando **`php artisan key:generate`**
7. Ejecuta el comando **`php artisan migrate`**
8. Ejecuta el comando **`php artisan serve`**
9. Ejecuta el comando **`php queue:work`**
10. La url  para las peticiones es [http://127.0.0.1:8000/api](http://127.0.0.1:8000/api)

## Proximamente: endpoints para hacer las solicitudes
