<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\LucaHome\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
    'routes' => [
		// Page
	   array('name' => 'page#index', 'url' => '/', 'verb' => 'GET'),
	   array('name' => 'page#do_echo', 'url' => '/echo', 'verb' => 'POST'),

		// WirelessSocket
		array('name' => 'wireless_socket#get', 'url' => '/api/v1/wireless_socket', 'verb' => 'GET'),
		array('name' => 'wireless_socket#get_for_id', 'url' => '/api/v1/wireless_socket/{id}', 'verb' => 'GET'),
		array('name' => 'wireless_socket#add', 'url' => '/api/v1/wireless_socket', 'verb' => 'POST'),
		array('name' => 'wireless_socket#update', 'url' => '/api/v1/wireless_socket/{id}', 'verb' => 'PUT'),
		array('name' => 'wireless_socket#delete', 'url' => '/api/v1/wireless_socket/{id}', 'verb' => 'DELETE'),

		// Area
		array('name' => 'area#get', 'url' => '/api/v1/area', 'verb' => 'GET'),
		array('name' => 'area#get_for_id', 'url' => '/api/v1/area/{id}', 'verb' => 'GET'),
		array('name' => 'area#add', 'url' => '/api/v1/area', 'verb' => 'POST'),
		array('name' => 'area#update', 'url' => '/api/v1/area/{id}', 'verb' => 'PUT'),
		array('name' => 'area#delete', 'url' => '/api/v1/area/{id}', 'verb' => 'DELETE'),
    ]
];
