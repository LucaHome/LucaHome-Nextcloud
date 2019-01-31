<?php

/**
 * Source: https://github.com/nextcloud/bookmarks/blob/master/lib/Http/RequestFactory.php
 */

namespace OCA\LucaHome\Http;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
use GuzzleHttp\Psr7\Request;

class RequestFactory implements RequestFactoryInterface {
	/**
	 * Create a new request.
	 *
	 * @param string $method The HTTP method associated with the request.
	 * @param UriInterface|string $uri The URI associated with the request.
	 * @return RequestInterface
	 */
	public function createRequest(string $method, $uri) : RequestInterface {
		$req = new Request($method, $uri);
		return $req;
	}
}