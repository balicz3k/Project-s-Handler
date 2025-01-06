<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('projects', 'ProjectController');
Routing::get('addProject', 'ProjectController');
Routing::get('user', 'UserController');
Routing::post('update', 'UserController');
Routing::post('update', 'UserController');
Routing::post('update', 'UserController');
Routing::post('addProject', 'ProjectController');
Routing::post('login', 'SecurityController');
Routing::post('register', 'SecurityController');
Routing::post('logout', 'SecurityController');

Routing::run($path);