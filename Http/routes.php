<?php

/**
 * @var Illuminate\Routing\Router $router
 */



$router->controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

$router->get('/despre', function(){ return view('despre'); });
