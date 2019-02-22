<?php

namespace OCA\LucaHome\Controller;

use OCA\LucaHome\Entities\Area;
use OCA\LucaHome\Services\AreaService;
use OCP\AppFramework\Controller;
use OCP\IRequest;

class AreaController extends Controller {

	/** @var AreaService */
	private $service;
	
	use Response;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param AreaService $service
	 */
	public function __construct(string $appName, IRequest $request, AreaService $service) {
		parent::__construct($appName, $request);
		$this->service = $service;
    }
    
	/**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
	 */
	public function index() {
		return $this->generateResponse("success", function () {
			return $this->service->get();
		}, null);
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     *
     * @param int $id
     */
    public function show($id) {
		return $this->generateResponse("error", function () {
			return "Not implemented";
		}, null);
    }
    
	/**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
	 * 
	 * @param string name
	 * @param string filter
	 */
	public function create($name, $filter) {
		$area = new Area();
		$area->id = -1;
		$area->name = $name;
		$area->filter = $filter;

		return $this->generateResponse("success", function () {
			return $this->service->add($area);
		}, null);
    }
    
	/**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
	 * 
     * @param int $id
	 * @param string name
	 * @param string filter
	 */
	public function update($id, $name, $filter) {
		$area = new Area();
		$area->id = $id;
		$area->name = $name;
		$area->filter = $filter;
		
		return $this->generateResponse("success", function () {
			return $this->service->update($area);
		}, null);
    }
    
	/**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
	 * 
     * @param int $id
	 */
	public function destroy($id) {
		return $this->generateResponse("success", function () {
			return $this->service->delete($id);
		}, null);
    }
}