<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/install', 'Install::index');
$routes->post('/install/system', 'Install::system');
$routes->post('/install/database', 'Install::database');
$routes->post('/install/admin', 'Install::admin');
$routes->get('/install/run', 'Install::run');
$routes->get('/install/success', 'Install::success');

$routes->get('/', 'Auth::index');
$routes->post('auth/login', 'Auth::logar'); // Processa login
$routes->get('auth/logout', 'Auth::logout'); // Logout


// Grupo de rotas protegidas (Dashboard)
$routes->group('dashboard',['filter'=>'auth'], function($routes) {
    $routes->get('/', 'Dashboard::index');
    // Futuros módulos entrarão aqui
});
