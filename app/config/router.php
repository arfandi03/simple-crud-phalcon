<?php

$router = $di->getRouter();

// Define your routes here

$router->add('/index/regis', ['controller' => 'index', 'action' => 'register']);
$router->add('/index/edit', ['controller' => 'index', 'action' => 'edit']);
$router->add('/index/edit/submit', ['controller' => 'index', 'action' => 'editSubmit']);
$router->add('/index/delete', ['controller' => 'index', 'action' => 'delete']);

$router->handle($_SERVER['REQUEST_URI']);
