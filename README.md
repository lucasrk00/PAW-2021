# Programación en Ambiente Web - UNLu 2021

### Trabájo práctico Nro1
* [Wireframes](https://www.figma.com/file/jQMMTd8Lr03jn2oPnYBbGK/PAW)
#### SiteMap:
![sitemap](https://raw.githubusercontent.com/lucasrk00/PAW-2021/master/images/Sitemap.png)

### Pre ejecución
Es necesario tener los siguientes parámetros habilitados en el archivo "php.ini"

- extension=mbstring
- extension=exif
- extension=pdo_pgsql

Es necesario tener instalado
- docker
- php 7.4.x
- compose
- phinx

#### Ejecución:

Buildear la imagen de docker
```sh
docker build -t <nombre> .
```
Correr la base de datos en docker
```sh
docker run <nombre>
```

Instalar las dependencias
```sh
composer update
```

Correr las migraciones
```sh
phinx migrate
```

Correr el seed para llenar la base de datos con ejemplos
```sh
phinx seed:run
```

Correr el servidor php
```sh
php -S localhost:8080 -t ./public
```