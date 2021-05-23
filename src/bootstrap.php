<?php

use Paw\Core\Request;
use Paw\Core\Router;

use Paw\Core\Config;
use Paw\Core\Database\ConnectionBuilder;

use Dotenv\Dotenv;
session_start();

$dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->load();

$config = new Config;

$connectionBuilder = new ConnectionBuilder;
$connection = $connectionBuilder->make($config);

$request = new Request;
$router = new Router;

/* GET */
$router->get('/', 'RoutesController@index');
$router->get('/institucion', 'RoutesController@institucion');
$router->get('/listaDeTurnos', 'RoutesController@listaDeTurnos');
$router->get('/noticias', 'RoutesController@noticias');
$router->get('/obrasSociales', 'ObrasSocialesController@obrasSociales');
$router->get('/profesionales', 'ProfesionalController@profesionales');

$router->get('/noticias', 'RoutesController@noticias');
$router->get('/noticia', 'RoutesController@noticia');

$router->get('/solicitarTurno', 'TurnoController@solicitarTurnoView');
$router->get('/confirmarTurno', 'TurnoController@confirmarTurnoView');
$router->get('/listaDeTurnos', 'TurnoController@listaDeTurnosView');

$router->get('/logout', 'AuthController@logout');
$router->get('/login', 'AuthController@loginView');
$router->get('/registrarse', 'AuthController@registerView');
/* POST */
$router->post('/login', 'AuthController@login');
$router->post('/registrarse', 'AuthController@register');
$router->post('/solicitarTurno', 'TurnoController@solicitarTurno');
$router->post('/confirmarTurno', 'TurnoController@confirmarTurno');
$router->post('/cancelarTurno', 'TurnoController@cancelarTurno');

/* ERROR */
$router->error('notFound', 'ErrorsController@notFound');
$router->error('internal', 'ErrorsController@internalError');

$router->direct($request);
