<?php

namespace OCA\WirelessControl\Controller;

use OCP\AppFramework\ApiController;
use OCP\IRequest;

class PingApiController extends ApiController {

	use Response;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 */
	public function __construct(string $appName, IRequest $request) {
		parent::__construct($appName, $request);
    }
    
	/**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
	 */
	public function index() {
		return $this->generateResponse("success", function () {
			return "Ping successful";
		}, '');
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     *
     * @param int $id
     */
    public function show(int $id) {
		return $this->generateResponse("error", function () {
			return "Not implemented";
		}, '');
    }
    
	/**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
	 * 
	 */
	public function create() {
		return $this->generateResponse("error", function () {
			return "Not implemented";
		}, '');
    }
    
	/**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
	 * 
     * @param int $id
	 */
	public function update(int $id) {
		return $this->generateResponse("error", function () {
			return "Not implemented";
		}, '');
    }
    
	/**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
	 * 
     * @param int $id
	 */
	public function destroy(int $id) {
		return $this->generateResponse("error", function () {
			return "Not implemented";
		}, '');
    }
}