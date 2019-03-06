<?php

namespace OCA\WirelessControl\Controller;

use Closure;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\JSONResponse;

trait Response {
	protected function generateResponse (string $status, Closure $callback, string $message) {
		$httpStatusCode = Http::STATUS_OK;

		try {
			$message = [
				'status' => $status,
				'data' => $callback(),
				'message' => $message
			];
		} catch(\Exception $e) {
			$message = [
				'status' => 'error',
				'data' => null,
				'message' => $e->getMessage()
			];
			$httpStatusCode = Http::STATUS_INTERNAL_SERVER_ERROR;
		}
		
		return new JSONResponse($message, $httpStatusCode);
	}
}