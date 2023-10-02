WareHouse README.MD

CARACTERÍSTICAS
-php 8.1
-laravel 9


INSTALANDO:

1.- Clonar el proyecto

2.- Cambiar al directorio del proyecto local

3.- Instalar dependencias:

>composer install

4.- Crea un nuevo archivo /databases/my_db.sqlite (o el nombre que prefieras)

5.- Acceso a la base de datos

copie example.env.example y cambie el nombre a .env

Ajuste las configuraciones de su bases de datos en el archivo .env

DB_CONNECTION=sqlite

DB_DATABASE=my_db.sqlite
Quizás debas incluir la ruta absoluta.

6.- Generar el proyecto clave:

>php artisan key:generate

7.- Migrar y ejecutar los seeders

>php artisan migrate --seed

8.- Inicializa tu servidor web local

9.- Acceso al Panel de Administración:
http://tudominio/admin

Usuarios
SuperAdmin: superadmin@example.com    (Tiene todos los privilegios)
contraseña: 12345678

Almacenero: jr@example.com  (Este es un usuario de ejemplo)
contraseña: 12345678

Puede cambiar su nombre, correo electrónico y contraseña en el panel de control.

Nota: Tal vez debas usar http://tudominio/public en lugar de http://tudominio/ dependiendo de tu servidor web.

¡Disfrútala!

