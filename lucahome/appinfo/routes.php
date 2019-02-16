<?php

/**
 * This file is licensed under the MIT License.
 * 
 * @author Jonas  Schubert
 * @copyright 2019 Jonas Schubert  <guepardoapps@gmail.com>
 * 
 * Help: 
 * https://github.com/nextcloud/bookmarks/blob/master/appinfo/routes.php
 * https://github.com/nextcloud/tasks/blob/master/appinfo/routes.php
 */

namespace OCA\LucaHome;

// use \OCP\AppFramework\App;
use \OCA\LucaHome\AppInfo\Application;

$application = new Application();

$application->registerRoutes($this, array('routes' => array(
	// Web Template Route
	array('name' => 'web_view#index', 'url' => '/', 'verb' => 'GET'),
	
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
	
	// Settings
	array('name' => 'settings#set_sorting', 'url' => '/settings/sort', 'verb' => 'POST'),
	array('name' => 'settings#get_sorting', 'url' => '/settings/sort', 'verb' => 'GET'),
	array('name' => 'settings#set_view_mode', 'url' => '/settings/view', 'verb' => 'POST'),
    array('name' => 'settings#get_view_mode', 'url' => '/settings/view', 'verb' => 'GET')
)));
