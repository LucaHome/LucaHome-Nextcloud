<?php
/**
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\LucaHome\Controller\Rest;

use \OCA\LucaHome\Enums\ErrorCode;
use \OCA\LucaHome\Entities\Area;
use \OCA\LucaHome\Services\AreaService;
use \OCP\AppFramework\ApiController;
use \OCP\AppFramework\Http\JSONResponse;
use \OCP\AppFramework\Http;
use \OCP\IConfig;
use \OCP\ILogger;
use \OCP\IRequest;

class AreaController extends ApiController implements IAreaController {

	/** @var string */
    private $userId;
    
	/** @var ILogger */
	private $logger;

	/** @var AreaService */
	private $service;
    
	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param string $userId
	 */
	public function __construct($appName, IRequest $request, $userId, ILogger $logger, AreaService $service) {
		parent::__construct($appName, $request);
		$this->userId = $userId;
		$this->logger = $logger;
		$this->service = $service;
    }
    
	/**
	 * @brief returns all areas
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function get() {
		try {
			$serviceResponse = $this->service->get($this->userId);
		} catch (\Exception $e) {
			$this->logger->logException($e, ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => $e,
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_INTERNAL_SERVER_ERROR);
		}
        
		return new JSONResponse([
			'error' => NULL,
			'response' => $serviceResponse,
			'status' => 'success'
		], Http::STATUS_OK);
    }
    
	/**
	 * @brief returns a single area based on its' id for a user
     * @param int id
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function getForId(int $id) {
		try {
			$serviceResponse = $this->service->getForId($id, $this->userId);
		} catch (\Exception $e) {
			$this->logger->logException($e, ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => $e,
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_INTERNAL_SERVER_ERROR);
        }
        
		return new JSONResponse([
			'error' => NULL,
			'response' => $serviceResponse,
			'status' => 'success'
		], Http::STATUS_OK);
    }
    
	/**
	 * @brief Add an Area
	 * @param string name
	 * @param string filter
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function add($name, $filter) {
		if (isset($name)) {
			$name = trim($name);
		} else {
			$this->logger->logException('Invalid empty parameter name in AreaController::add', ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => 'Invalid empty parameter name in AreaController::add',
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_BAD_REQUEST );
		}

		if (isset($filter)) {
			$filter = trim($filter);
		} else {
			$this->logger->logException('Invalid empty parameter filter in AreaController::add', ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => 'Invalid empty parameter filter in AreaController::add',
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_BAD_REQUEST );
		}

		$area = new Area();
		$area->name =  $name;
		$area->filter =  $filter;

		try {
			$serviceResponse = $this->service->add($area, $this->userId);
		} catch (\Exception $e) {
			$this->logger->logException($e, ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => $e,
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_INTERNAL_SERVER_ERROR);
        }
        
		return new JSONResponse([
			'error' => NULL,
			'response' => $serviceResponse,
			'status' => 'success'
		], Http::STATUS_OK);
    }
    
	/**
	 * @brief Update an Area
	 * @param int id
	 * @param string name
	 * @param string filter
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function update(int $id, $name, $filter) {
		if($id < 0)  {
			$this->logger->logException('Invalid parameter id in AreaController::update', ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => 'Invalid parameter id in AreaController::update',
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_BAD_REQUEST );
		}
		
		if (isset($name)) {
			$name = trim($name);
		} else {
			$this->logger->logException('Invalid empty parameter name in AreaController::update', ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => 'Invalid empty parameter name in AreaController::update',
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_BAD_REQUEST );
		}

		if (isset($filter)) {
			$filter = trim($filter);
		} else {
			$this->logger->logException('Invalid empty parameter filter in AreaController::update', ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => 'Invalid empty parameter filter in AreaController::update',
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_BAD_REQUEST );
		}

		$area = $this->service->getForId($id, $this->userId);
		$area->name =  $name;
		$area->filter =  $filter;

		try {
			$serviceResponse = $this->service->update($area, $this->userId);
		} catch (\Exception $e) {
			$this->logger->logException($e, ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => $e,
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_INTERNAL_SERVER_ERROR);
        }
		
		return new JSONResponse([
			'error' => NULL,
			'response' => $serviceResponse,
			'status' => 'success'
		], Http::STATUS_OK);
    }
    
	/**
	 * @brief Delete an Area
	 * @param int id
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function delete(int $id) {
		if($id < 0)  {
			$this->logger->logException('Invalid parameter id in AreaController::delete', ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => 'Invalid parameter id in AreaController::delete',
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_BAD_REQUEST );
		}

		try {
			$serviceResponse = $this->service->delete($id, $this->userId);
		} catch (\Exception $e) {
			$this->logger->logException($e, ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => $e,
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_INTERNAL_SERVER_ERROR);
        }
		
		return new JSONResponse([
			'error' => NULL,
			'response' => $serviceResponse,
			'status' => 'success'
		], Http::STATUS_OK);
    }
}