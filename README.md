
# CREASOFT
Proyecto de contactos para ofertas

## BACK-END
`creasoft/back-end/creasoft-app`

Las API se generaron utilizando Laravel en su versión estable 10 con PHP 8.2.13

### Librerías utilizadas:
* [laravel-make-service](https://github.com/getsolaris/laravel-make-service): Para la generación automática de servicios.
* [spanish](https://github.com/Laraveles/spanish): Proporciona respuestas de error en español para las APIs.
* [jwt-auth](https://github.com/PHP-Open-Source-Saver/jwt-auth): Para la autenticación.
* [Laravel Excel](https://laravel-excel.com/): Para la exportación de datos organizados basados en excel.

### Migraciones y base de datos:
Las migraciones se realizan desde Laravel para facilitar el cambio de base de datos si fuera necesario. Se organizan según su función y se utilizan UUID según sea necesario.

### Semilla de datos:
Se incluye una semilla para la inicialización del proyecto. Las credenciales generadas por defecto son:
>> **username**: kento | **password**: demo

### Estructura del proyecto:
- Las rutas están organizadas según su función, con consideración del uso de middleware JWT para la verificación de accesos.
- Modelos, controladores y servicios se organizan según su función.
- Los Request están asociados a los controladores, y los Resource a los servicios correspondientes.

### Prefijo de API y CORS:
Se accede a las rutas con el prefijo _v1_, configurado en los CORS. Este prefijo se define desde RouteServiceProvider.

### Notas adicionales:
- `composer i` Para instalar las dependencias.
- Copiar el env.example en un archivo .env para colocar sus variables de entorno locales.
- `php artisan migrate --seed` Para tener toda la estructura de la base de datos y semillas iniciales.
- Los formularios están almacenados en la tabla `tbl_data_customer`.
- Las exportaciones de datos del formulario se guardan en `tbl_data_customer_exports`.
- Los usuarios se encuentran en la tabla `tbl_user`.

## FRONT-END
`creasoft/front-end/src`

Se ha realizado la maquetación de la web utilizando únicamente las siguientes herramientas:
* HTML
* CSS
* JavaScript

La maquetación ha sido diseñada para ser visualizada de manera responsive en dispositivos móviles, tomando como referencia el smartphone S20 Ultra y utilizando las opciones de emulación de dispositivos en el navegador Google Chrome.

Se ha integrado una API proporcionada por el back-end para el llenado del formulario.

### Inicio de sesión:
Para iniciar sesión se solicita el nombre de usuario y su contraseña.
>> Nombre de usuario: kento | Contraseña: demo

El formulario de inicio de sesión se encuentra ubicado en la parte superior del carrusel para facilitar el acceso.

### Persistencia de la sesión:
El manejo de la persistencia de la sesión se ha implementado utilizando LocalStorage.

### Panel:
Al acceder al panel lo primero que cargará será la lectura de la data recibida en los formularios, se cuenta con paginación, filtro por fechas (se toma como base a la semana actual).

Se ha habilitado un cierre de sesión persistente para asegurar que el acceso al panel y su información no sea libre.

### Exportación de datos:
La exportación toma como parámetros a los filtros actuales para pasar la data a formato xls que se descargará directamente desde el navegador usado.



## API
`creasoft/api`

Dentro de la carpeta `api`, se incluye un archivo para la exportación de la colección creada en Postman, así como una captura de pantalla que muestra una petición de inicio de sesión.

Se utiliza una variable para la ruta base del servidor, especialmente útil para entornos locales. En este caso, la variable se configura de la siguiente manera:

| Llave  | Valor           |
| ------ | --------------- |
| Variable          | Localhost       |
| Valor inicial     | http://127.0.0.1:8000/v1    |
| Valor actual      | http://127.0.0.1:8000/v1    |

Esto permite realizar pruebas en el servidor de manera sencilla, modificando el valor actual según sea necesario.

Para el manejo de tokens, se utiliza la configuración de la carpeta principal de Postman. Se define el tipo de token como **Bearer Token** y se proporciona el valor del token para que todas las peticiones tengan automáticamente el token en la cabecera.

Se ha realizado una publicación simple de la colección en Postman para una rápida visualización. Se debe tener en cuenta que en la publicación se muestra la ruta inicial configurada, y no la variable definida previamente como `{{Localhost}}`.

[Documentación de POSTMAN](https://documenter.getpostman.com/view/2sA2xnyAUb?version=latest)


## BD MODEL
`creasoft/bd-model`

La base de datos se ha generado utilizando las migraciones de Laravel y se ha organizado utilizando **MySQL Workbench** para mejorar la legibilidad y comprensión de cómo se estructuran las tablas según la lógica del negocio. Se ha incluido un archivo PDF para facilitar su visualización.
