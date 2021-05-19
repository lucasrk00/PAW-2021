<?php

use Paw\Core\Request;
use Paw\Core\Router;

$request = new Request;
$router = new Router;

/* GET */
$router->get('/', 'RoutesController@index');
$router->get('/institucion', 'RoutesController@institucion');
$router->get('/listaDeTurnos', 'RoutesController@listaDeTurnos');
$router->get('/login', 'RoutesController@login');
$router->get('/noticias', 'RoutesController@noticias');
$router->get('/obrasSociales', 'RoutesController@obrasSociales');
$router->get('/profesionales', 'RoutesController@profesionales');
$router->get('/registrarse', 'RoutesController@registrarse');
$router->get('/solicitarTurno', 'TurnoController@solicitarTurnoView');

/* POST */
$router->post('/solicitarTurno', 'TurnoController@solicitarTurno');

/* ERROR */
$router->error('notFound', 'ErrorsController@notFound');
$router->error('internal', 'ErrorsController@internalError');

$router->direct($request);
