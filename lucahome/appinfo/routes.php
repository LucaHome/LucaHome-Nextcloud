<?php
/**
 * This file is licensed under MIT License.
 * @author Jonas  Schubert <guepardoapps@gmail.com>
 * @copyright (c) 2019, Jonas Schubert
 * Source: https://github.com/nextcloud/bookmarks/blob/master/appinfo/routes.php
 */

namespace OCA\Bookmarks\AppInfo;

/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
$application = new Application();

$application->registerRoutes($this, ['routes' => [
	// Web Template Route
	['name' => 'web_view#index', 'url' => '/', 'verb' => 'GET'],
	
	// WirelessSocket
    ['name' => 'wireless_socket#get', 'url' => '/api/v1/wireless_socket', 'verb' => 'GET'],
	['name' => 'wireless_socket#get_for_user', 'url' => '/api/v1/wireless_socket/user', 'verb' => 'GET'],
	['name' => 'wireless_socket#get_for_id', 'url' => '/api/v1/wireless_socket/{id}', 'verb' => 'GET'],
	['name' => 'wireless_socket#add', 'url' => '/api/v1/wireless_socket', 'verb' => 'POST'],
	['name' => 'wireless_socket#update', 'url' => '/api/v1/wireless_socket/{id}', 'verb' => 'PUT'],
	['name' => 'wireless_socket#set_state', 'url' => '/api/v1/wireless_socket/state/{id}', 'verb' => 'PUT'],
	['name' => 'wireless_socket#delete', 'url' => '/api/v1/wireless_socket/{id}', 'verb' => 'DELETE'],
	
	// Settings
	['name' => 'settings#set_sorting', 'url' => '/settings/sort', 'verb' => 'POST'],
	['name' => 'settings#get_sorting', 'url' => '/settings/sort', 'verb' => 'GET'],
	['name' => 'settings#set_view_mode', 'url' => '/settings/view', 'verb' => 'POST'],
    ['name' => 'settings#get_view_mode', 'url' => '/settings/view', 'verb' => 'GET']
]]);
