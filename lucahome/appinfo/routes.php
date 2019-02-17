<?php
/**
* Nextcloud - LucaHome
*
* @author Jonas Schubert
* @copyright 2019 Jonas Schubert <guepardoapps@gmail.com>
*
* MIT License
* Copyright (c) 2019 GuepardoApps (Jonas Schubert)
* Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

namespace OCA\LucaHome;

use \OCA\Tasks\AppInfo\Application;

$application = new Application();

$application->registerRoutes($this, array('routes' => array(
	// Page
	array('name' => 'page#index', 'url' => '/', 'verb' => 'GET'),

	// Templates
	array('name' => 'page#templates', 'url' => '/templates/{template}', 'verb' => 'GET'),

	// WirelessSocket
	array('name' => 'wireless_socket#get', 'url' => '/api/v1/wireless_socket', 'verb' => 'GET'),
	array('name' => 'wireless_socket#add', 'url' => '/api/v1/wireless_socket', 'verb' => 'POST'),
	array('name' => 'wireless_socket#update', 'url' => '/api/v1/wireless_socket/{id}', 'verb' => 'PUT'),
	array('name' => 'wireless_socket#delete', 'url' => '/api/v1/wireless_socket/{id}', 'verb' => 'DELETE'),

	// Area
	array('name' => 'area#get', 'url' => '/api/v1/area', 'verb' => 'GET'),
	array('name' => 'area#add', 'url' => '/api/v1/area', 'verb' => 'POST'),
	array('name' => 'area#update', 'url' => '/api/v1/area/{id}', 'verb' => 'PUT'),
	array('name' => 'area#delete', 'url' => '/api/v1/area/{id}', 'verb' => 'DELETE'),

	// Settings
	array('name' => 'settings#get',	'url' => '/settings', 'verb' => 'GET'),
	array('name' => 'settings#set', 'url' => '/settings/{setting}/{value}', 'verb' => 'POST')
)));
