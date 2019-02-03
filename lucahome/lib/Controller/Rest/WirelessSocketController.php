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
			$wirelessSocketList = $this->service->get($this->userId);
		} catch (\Exception $e) {
			$this->logger->logException($e, ['app' => 'lucahome']);
			return new JSONResponse([], Http::STATUS_INTERNAL_SERVER_ERROR);
        }
        
		return new JSONResponse(['wirelessSocketList' => $wirelessSocketList], Http::STATUS_OK);
    }
    
	/**
	 * @brief returns all wireless sockets for a user
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function getForUser() {
		try {
			$wirelessSocketList = $this->service->getForUser($this->userId);
		} catch (\Exception $e) {
			$this->logger->logException($e, ['app' => 'lucahome']);
			return new JSONResponse([], Http::STATUS_INTERNAL_SERVER_ERROR);
        }
        
		return new JSONResponse(['wirelessSocketList' => $wirelessSocketList], Http::STATUS_OK);
    }
}