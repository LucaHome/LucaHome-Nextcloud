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
use \OCA\LucaHome\Entities\WirelessSocket;
use \OCA\LucaHome\Services\WirelessSocketService;
use \OCP\AppFramework\ApiController;
use \OCP\AppFramework\Http\JSONResponse;
use \OCP\AppFramework\Http;
use \OCP\IConfig;
use \OCP\ILogger;
use \OCP\IRequest;

class WirelessSocketController extends ApiController implements IWirelessSocketController {

	/** @var string */
    private $userId;
    
	/** @var ILogger */
	private $logger;

	/** @var WirelessSocketService */
	private $service;
    
	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param string $userId
	 */
	public function __construct($appName, IRequest $request, $userId, ILogger $logger, WirelessSocketService $service) {
		parent::__construct($appName, $request);
		$this->userId = $userId;
		$this->logger = $logger;
		$this->service = $service;
    }
    
	/**
	 * @brief returns all wireless sockets
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
	 * @brief returns a single wireless socket based on its' id for a user
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
	 * @brief Add a WirelessSocket
	 * @param string name
	 * @param string code
	 * @param string area
	 * @param string description
	 * @param string icon
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function add($name, $code, $area, $description, $icon) {
		if (isset($name)) {
			$name = trim($name);
		} else {
			$this->logger->logException('Invalid empty parameter name in WirelessSocketController::add', ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => 'Invalid empty parameter name in WirelessSocketController::add',
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_BAD_REQUEST );
		}

		if (isset($code)) {
			$code = trim($code);
		} else {
			$this->logger->logException('Invalid empty parameter code in WirelessSocketController::add', ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => 'Invalid empty parameter code in WirelessSocketController::add',
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_BAD_REQUEST );
		}

		if (isset($area)) {
			$area = trim($area);
		} else {
			$area = "";
		}

		if (isset($description)) {
			$description = trim($description);
		} else {
			$description = "";
		}

		if (isset($icon)) {
			$icon = trim($icon);
		} else {
			$icon = "";
		}
		
		$wirelessSocket = new WirelessSocket();
		$wirelessSocket->name =  $name;
		$wirelessSocket->code =  $code;
		$wirelessSocket->area =  $area;
		$wirelessSocket->state =  0;
		$wirelessSocket->description =  $description;
		$wirelessSocket->icon =  $icon;

		try {
			$serviceResponse = $this->service->add($wirelessSocket, $this->userId);
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
	 * @brief Update a WirelessSocket
	 * @param int id
	 * @param string name
	 * @param string code
	 * @param string area
	 * @param string description
	 * @param string icon
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function update(int $id, $name, $code, $area, $description, $icon) {
		if($id < 0)  {
			$this->logger->logException('Invalid parameter id in WirelessSocketController::update', ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => 'Invalid parameter id in WirelessSocketController::update',
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_BAD_REQUEST );
		}
		
		if (isset($name)) {
			$name = trim($name);
		} else {
			$this->logger->logException('Invalid empty parameter name in WirelessSocketController::update', ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => 'Invalid empty parameter name in WirelessSocketController::update',
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_BAD_REQUEST );
		}

		if (isset($code)) {
			$code = trim($code);
		} else {
			$this->logger->logException('Invalid empty parameter code in WirelessSocketController::update', ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => 'Invalid empty parameter code in WirelessSocketController::update',
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_BAD_REQUEST );
		}

		if (isset($area)) {
			$area = trim($area);
		} else {
			$area = "";
		}

		if (isset($description)) {
			$description = trim($description);
		} else {
			$description = "";
		}

		if (isset($icon)) {
			$icon = trim($icon);
		} else {
			$icon = "";
		}
		
		$wirelessSocket = $this->service->getForId($id, $this->userId);
		$wirelessSocket->name =  $name;
		$wirelessSocket->code =  $code;
		$wirelessSocket->area =  $area;
		$wirelessSocket->description =  $description;
		$wirelessSocket->icon =  $icon;

		try {
			$serviceResponse = $this->service->update($wirelessSocket, $this->userId);
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
	 * @brief Delete a WirelessSocket
	 * @param int id
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function delete(int $id) {
		if($id < 0)  {
			$this->logger->logException('Invalid parameter id in WirelessSocketController::delete', ['app' => 'lucahome']);
			return new JSONResponse([
				'error' => 'Invalid parameter id in WirelessSocketController::delete',
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