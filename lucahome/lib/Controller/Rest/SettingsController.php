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

use \OCP\AppFramework\ApiController;
use \OCP\AppFramework\Http\JSONResponse;
use \OCP\AppFramework\Http;
use \OCP\IConfig;
use \OCP\IRequest;

class SettingsController extends ApiController implements ISettingsController {

	/** @var IConfig */
    private $config;
    
	/** @var string */
    private $userId;
    
	/**
	 * @param string appName
	 * @param IRequest request
	 * @param string userId
	 * @param IConfig config
	 */
	public function __construct(
		$appName,
		IRequest $request,
		$userId,
		IConfig $config
	) {
		parent::__construct($appName, $request);
		$this->config = $config;
		$this->userId = $userId;
    }
    
	/**
	 * get sorting option config value
	 *
	 * @param string entity
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function getSorting($entity = "") {
		try {
			$sorting = $this->config->getUserValue(
				$this->userId,
				$this->appName,
				$entity . 'sorting',
				'lastmodified' //default value
			);
		} catch (\Exception $e) {
			return new JSONResponse([
				'error' => $e,
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_INTERNAL_SERVER_ERROR);
        }
        
		return new JSONResponse([
			'error' => NULL,
			'response' => $sorting,
			'status' => 'success'
		], Http::STATUS_OK);
    }
    
	/**
	 * set sorting option config value
	 *
	 * @param string entity
	 * @param string sorting
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function setSorting($entity = "", $sorting = "") {
		$legalArguments = ['id','name','area','code','added','clickcount','lastmodified'];
		if (!in_array($sorting, $legalArguments)) {
			return new JSONResponse([
				'error' => 'Invalid parameter sorting in SettingsController::setSorting',
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_BAD_REQUEST);
		}
		
		try {
			$this->config->setUserValue(
				$this->userId,
				$this->appName,
				$entity . 'sorting',
				$sorting
			);
		} catch (\Exception $e) {
			return new JSONResponse([
				'error' => $e,
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_INTERNAL_SERVER_ERROR);
        }
        
		return new JSONResponse([
			'error' => NULL,
			'response' => $sorting,
			'status' => 'success'
		], Http::STATUS_OK);
    }
    
	/**
	 * get view mode option config value
	 *
	 * @param string entity
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function getViewMode($entity = "") {
		try {
			$viewMode = $this->config->getUserValue(
				$this->userId,
				$this->appName,
				$entity . 'viewMode',
				'grid' //default value
			);
		} catch (\Exception $e) {
			return new JSONResponse([
				'error' => $e,
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_INTERNAL_SERVER_ERROR);
        }
        
		return new JSONResponse([
			'error' => NULL,
			'response' => $viewMode,
			'status' => 'success'
		], Http::STATUS_OK);
    }
    
	/**
	 * set sorting option config value
	 *
	 * @param string entity
	 * @param string sorting
	 * @return JSONResponse
	 *
	 * @NoAdminRequired
	 */
	public function setViewMode($entity = "", $viewMode = "") {
		$legalArguments = ['grid', 'list'];
		if (!in_array($viewMode, $legalArguments)) {
			return new JSONResponse([
				'error' => 'Invalid parameter viewMode in SettingsController::setViewMode',
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_BAD_REQUEST);
		}

		try {
			$this->config->setUserValue(
				$this->userId,
				$this->appName,
				$entity . 'viewMode',
				$viewMode
			);
		} catch (\Exception $e) {
			return new JSONResponse([
				'error' => $e,
				'response' => NULL,
				'status' => 'error'
			], Http::STATUS_INTERNAL_SERVER_ERROR);
        }
        
		return new JSONResponse([
			'error' => NULL,
			'response' => $viewMode,
			'status' => 'success'
		], Http::STATUS_OK);
	}
}