# Programación en Ambiente Web - UNLu 2021
## Ejecución
### Requisitos para la ejecución
Es necesario tener habilitadas las siguientes extensiones de PHP
```
extension=mbstring
extension=exif
extension=pdo_pgsql
```
Puede activarlas descomentando esas líneas en su archivo `php.ini`

Además es necesario tener instalado:
- php 7.4.x
- compose
- phinx
- Base de Datos postgreSQL
### Instalar dependencias
Es necesario instalar las dependencias correspondientes al proyecto corriendo el siguiente comando
```sh
composer update
```

### Configurar las variables de entorno
Es necesario duplicar el archivo `.env.example` y llamarlo `.env`. Luego completar las variables con su configuración correspondiente a su base de datos

### Base de datos
Es necesario correr las migraciones con el siguiente comando
```sh
phinx migrate
```

Y luego correr los seeds
```sh
phinx seed:run
```

### Correr el Servidor
```sh
php -S localhost:8080 -t ./public
```



## Trabájo práctico Nro1
* [Wireframes](https://www.figma.com/file/jQMMTd8Lr03jn2oPnYBbGK/PAW)
#### SiteMap:
![sitemap](https://raw.githubusercontent.com/lucasrk00/PAW-2021/master/images/Sitemap.png)
