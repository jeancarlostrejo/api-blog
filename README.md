<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Api Blog

## Descripción

Api que permite a los usuarios registrarse, y una ves registrados y logueados podrán crear, listar, editar y eliminar publicaciones; también pueden comentar las publicaciones, así como también permite darle "me gusta" a las publicaciones de otros usuarios y subscribirse a éstos para que cuando suban una nueva publicación, les llegue una notificacion por correo notificandoles de la creación.

## Funcionalidades 
+ Los usuarios pueden registrarse y loguearse (recibiran un token de acceso al loguearso, el cual les permitirá interactuar con la api)
+ Los usuarios pueden hacer operaciones crud sobre sus publicaciones.
+ Las publicaciónes tienen los siguientes campos:
    - title: El título del post.
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
## EndPoints
### Registrarse

* **Método:** POST
* **URL:** api/register
* **Descripción:** Registrarse para poder hacer las operaciones
* **Ejemplo de body de la solicitud:**
  ```json
    {
        "name": "Monkey D. Luffy",
        "email": "luffy@nika.com",
        "password": "password"
    },
* **Respuesta: código 201**
  ```json
    {
        "message": "User registered successfully"
    }
### Loguearse
* **Método:** POST
* **URL:** api/login
* **Descripción:** Loguearse con el usuario creado para obtener el token de acceso

* **Ejemplo de body de la solicitud:**
  ```json
    {
      "email": "luffy@nika.com",
      "password": "password"
    },
* **Respuesta: código 200**
  ```json
    {
        "message": "login successfully",
        "user": {
            "id": 12,
            "name": "Monkey D. Luffy",
            "email": "luffy@nika.com",
            "email_verified_at": null,
            "created_at": "2024-10-22T21:56:10.000000Z",
            "updated_at": "2024-10-22T21:56:10.000000Z"
        },
        "access_token": "9|rKpalj26SEcX52YuhgCawwExwnyt72ZzNEcaCPXv9b903009"
    }
* **Respuesta: código 401**
  ```json
    {
        "message": "Credentials incorrects"
    }

### Logout
* **Método:** GET
* **URL:** api/logout
* **Descripción:** Hacer logout e invalidar los tokens creados
* **Rspuesta:** código 204

### Crear publicaciones
* **Método:** POST
* **URL:** api/posts
* **Descripción:** Crear un nuevo post
* **Ejemplo de body de la solicitud:** debe colocar el token de acceso como bearer; el Content-Type = multipart/form-data para la subida del archivo de imagen; Accept = application/json
  ```json
    {
        "title": "Lo nuevo de laravel",
        "content": "Descubre las caracteristicas que ofrece el framework de php",
        "image": "archivo image",
        "category:id": "3",
    }
* **Respuesta: Código 201**
  ```json
    {
        "message": "Post created successfully",
        "data": {
            "title": "Lo nuevo de laravel",
            "content": "Descubre las caracteristicas que ofrece el framework de php",
            "image": "posts/ZG3MD6TyfZzpm8bZI0ilfVHFFsscAUK8Es5PybvE.png",
            "category_id": "3",
            "user_id": 3,
            "updated_at": "2024-10-22T22:12:33.000000Z",
            "created_at": "2024-10-22T22:12:33.000000Z",
            "id": 32
        }
    }

### Mostrar todos los posts
* **Método:** GET
* **URL:** api/posts
* **Descripción:** Obtiene todos los posts creados.
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token. NO REQUIERE UN BODY**
* **Respuesta: código 200**
  ```json
    {
        "data": [
            {
                "id": 1,
                "title": "Numquam deleniti aut nobis voluptates et.",
                "content": "Iusto sit ut sint. Adipisci temporibus omnis alias ipsa eaque. In nemo hic assumenda et.",
                "image": "posts/5c8fb1d7-9661-3310-89e5-a5ea6cc149db.jpg",
                "category_id": 3,
                "user_id": 4,
                "created_at": "2024-10-18T15:12:02.000000Z",
                "updated_at": "2024-10-18T15:12:02.000000Z",
                "comments": [
                    {
                        "id": 5,
                        "body": "Primer comentario oficial",
                        "user_id": 11,
                        "post_id": 1,
                        "created_at": "2024-10-20T02:09:24.000000Z",
                        "updated_at": "2024-10-20T02:09:24.000000Z"
                    }
                ]
            },
            {
                "id": 32,
                "title": "Lo nuevo de laravel",
                "content": "Descubre las caracteristicas que ofrece el framework de php",
                "image": "posts/ZG3MD6TyfZzpm8bZI0ilfVHFFsscAUK8Es5PybvE.png",
                "category_id": 3,
                "user_id": 3,
                "created_at": "2024-10-22T22:12:33.000000Z",
                "updated_at": "2024-10-22T22:12:33.000000Z",
                "comments": []
            }
        ]
    }
### Mostrar un post
* **Método:** GET
* **URL:** api/posts/32
* **Descripción:** Obtiene la información de un post, así como también las relaciones con otros modelos como pueden ser comentarios, cantidad de comentarios y cantidad de likes.
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token. NO REQUIERE UN BODY**
* **Respuesta: código 200**
  ```json
    {
        "id": 32,
        "title": "Lo nuevo de laravel",
        "content": "Descubre las caracteristicas que ofrece el framework de php",
        "image": "posts/ZG3MD6TyfZzpm8bZI0ilfVHFFsscAUK8Es5PybvE.png",
        "category_id": 3,
        "user_id": 3,
        "created_at": "2024-10-22T22:12:33.000000Z",
        "updated_at": "2024-10-22T22:12:33.000000Z",
        "comments_count": 0,
        "likes_count": 0,
        "comments": []
    }
### Actualizar un post
* **Método:** POST
* **URL:** api/posts/33
* **Descripción:** Actualizar la informacion del post cuyo id se pasa por parametro
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token, enviar un form-data con la información a actualizar IMPORTANTE debe enviarlo como metodo posth y hacer spoofing agregando un campo adicionar con el name = _method y el valor = put/path; El header Content-Type = multipart/form-data; boundary= simboloMenorcalculated when request is sentsimboloMayor**

### Eliminar un post
* **Método:** DELETE
* **URL:** api/posts/32
* **Descripción:** Elimina el posts con el identificador pasado por parametro
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token. NO REQUIERE UN BODY**
* **Respuesta: código de estado 204**

### Agregar un comentario
* **Método:** POST
* **URL:** api/posts/33/comments
* **Descripción:** agrega un comentario a un post
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token**
  ```json
    {
        "body": "Primer comentario oficial"
    }
* **Respuesta: código de estado 201**
  ```json
    {
        "message": "comment created successfully"
    }

### Eliminar un comentario
* **Método:** DELETE
* **URL:** api/comments/6
* **Descripción:** Elimina un comentario. **Consideracion:** solo pueden eliminar comentarios las personas que crearon el comentarios o el creador del post donde se hizo el comentario
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token. NO REQUIERE UN BODY**
* **Respuesta: código de estado 204**

### Dar/eliminar "me gusta"
* **Método:** POST
* **URL:** api/posts/33/likes
* **Descripción:** Permite dar "me gusta" a un posts (si aún no le habias dado) o eliminar el like (si ya habías dado "me gusta" antes)
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token. NO REQUIERE UN BODY**
* **Respuesta: código de estado para dar "me gusta" 201, para quitar "me gusta" 200**

### Subscribirse a un usuario
* **Método:** POST
* **URL:** api/users/4/subscribe
* **Descripción:** Permite subscribirse a un usuario si ya aún no estabas suscrito
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token. NO REQUIERE UN BODY**
* **Respuesta: código de estado 200**
  ```json
    {
        "message": "Subscribed satisfully"
    }

### Desuscribirse a un usuario
* **Método:** DELETE
* **URL:** api/users/4/unsubscribe
* **Descripción:** Permite desubscribirse a un usuario siempre y cuando ya hayas estado suscrito
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token. NO REQUIERE UN BODY**
* **Respuesta: código de estado 200**
  ```json
    {
        "message": "Unsubscribe satisfully"
    }

### Obteners los subscriptores de un usuario
* **Método:** GET
* **URL:** api/users/4/subscribers
* **Descripción:** Permite obtener a los subscriptores de un usuario 
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token. NO REQUIERE UN BODY**
* **Respuesta: código de estado 200**
  ```json
    {
        "data": [
            {
                "id": 1,
                "name": "Alaina Effertz",
                "email": "jemard@example.com",
                "email_verified_at": "2024-10-18T15:12:02.000000Z",
                "created_at": "2024-10-18T15:12:02.000000Z",
                "updated_at": "2024-10-18T15:12:02.000000Z",
                "pivot": {
                    "subscribed_to_id": 3,
                    "subscriber_id": 1
                }
            },
            {
                "id": 11,
                "name": "Jean Carlos Trejo",
                "email": "test@test.com",
                "email_verified_at": "2024-10-18T15:12:02.000000Z",
                "created_at": "2024-10-18T15:12:02.000000Z",
                "updated_at": "2024-10-18T15:12:02.000000Z",
                "pivot": {
                    "subscribed_to_id": 3,
                    "subscriber_id": 11
                }
            },
            {
                "id": 4,
                "name": "Prof. Cary White I",
                "email": "fmcglynn@example.net",
                "email_verified_at": "2024-10-18T15:12:02.000000Z",
                "created_at": "2024-10-18T15:12:02.000000Z",
                "updated_at": "2024-10-18T15:12:02.000000Z",
                "pivot": {
                    "subscribed_to_id": 3,
                    "subscriber_id": 4
                }
            },
            {
                "id": 5,
                "name": "Dr. Percy Olson",
                "email": "mbahringer@example.net",
                "email_verified_at": "2024-10-18T15:12:02.000000Z",
                "created_at": "2024-10-18T15:12:02.000000Z",
                "updated_at": "2024-10-18T15:12:02.000000Z",
                "pivot": {
                    "subscribed_to_id": 3,
                    "subscriber_id": 5
                }
            }
        ]
    }

### Obteners las subscripciones de un usuario
* **Método:** GET
* **URL:** api/users/4/subscriptions
* **Descripción:** Permite obtener los usuarios a los que está subscrita un otro usuaio
* **Ejemplo de body de la solicitud: debe colocar el token de accesos como bearer token. NO REQUIERE UN BODY**
* **Respuesta: código de estado 200**
  ```json
    {
        "data": [
            {
                "id": 1,
                "name": "Alaina Effertz",
                "email": "jemard@example.com",
                "email_verified_at": "2024-10-18T15:12:02.000000Z",
                "created_at": "2024-10-18T15:12:02.000000Z",
                "updated_at": "2024-10-18T15:12:02.000000Z",
                "pivot": {
                    "subscriber_id": 11,
                    "subscribed_to_id": 1
                }
            },
            {
                "id": 3,
                "name": "Catherine Beatty",
                "email": "lucy38@example.com",
                "email_verified_at": "2024-10-18T15:12:02.000000Z",
                "created_at": "2024-10-18T15:12:02.000000Z",
                "updated_at": "2024-10-18T15:12:02.000000Z",
                "pivot": {
                    "subscriber_id": 11,
                    "subscribed_to_id": 3
                }
            },
            {
                "id": 10,
                "name": "Alvina Douglas",
                "email": "sigmund26@example.net",
                "email_verified_at": "2024-10-18T15:12:02.000000Z",
                "created_at": "2024-10-18T15:12:02.000000Z",
                "updated_at": "2024-10-18T15:12:02.000000Z",
                "pivot": {
                    "subscriber_id": 11,
                    "subscribed_to_id": 10
                }
            }
        ]
    }