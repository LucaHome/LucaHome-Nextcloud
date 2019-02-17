<?php

namespace OCA\LucaHome\Controller;

use \OCA\LucaHome\Entities\Area;
use \OCA\LucaHome\Services\AreaService;
use \OCP\AppFramework\Controller;
use \OCP\IRequest;

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
	 * @brief returns all areas
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function get() {
		return $this->generateResponse("success", function () {
			return $this->service->get();
		}, null);
    }
    
	/**
	 * @brief Add an Area
	 * @param Area area
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function add(Area $area) {
		return $this->generateResponse("success", function () {
			return $this->service->add($area);
		}, null);
    }
    
	/**
	 * @brief Update an Area
	 * @param Area area
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function update(Area $area) {
		return $this->generateResponse("success", function () {
			return $this->service->update($area);
		}, null);
    }
    
	/**
	 * @brief Delete an Area
	 * @param int id
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function delete(int $id) {
		return $this->generateResponse("success", function () {
			return $this->service->delete($id);
		}, null);
    }
}