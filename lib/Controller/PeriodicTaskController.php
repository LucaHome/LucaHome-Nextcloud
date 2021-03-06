<?php

namespace OCA\WirelessControl\Controller;

use OCA\WirelessControl\Entities\PeriodicTask;
use OCA\WirelessControl\Services\PeriodicTaskService;
use OCP\AppFramework\Controller;
use OCP\IRequest;

class PeriodicTaskController extends Controller
{
	/** @var PeriodicTaskService */
	private $service;

	use Response;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param PeriodicTaskService $service
	 */
	public function __construct(string $appName, IRequest $request, PeriodicTaskService $service)
	{
		parent::__construct($appName, $request);
		$this->service = $service;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index()
	{
		return $this->generateResponse("success", function () {
			return $this->service->get();
		}, '');
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * @param int $id
	 */
	public function show(int $id)
	{
		return $this->generateResponse("success", function () use ($id) {
			return $this->service->getById($id);
		}, '');
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * 
	 * @param string name
	 * @param int wirelessSocketId
	 * @param int wirelessSocketState
	 * @param int weekday
	 * @param int hour
	 * @param int minute
	 * @param int periodic
	 * @param int active
	 */
	public function create(string $name, int $wirelessSocketId, int $wirelessSocketState, int $weekday, int $hour, int $minute, int $periodic, int $active)
	{
		$periodicTask = new PeriodicTask();
		$periodicTask->id = -1;
		$periodicTask->name = $name;
		$periodicTask->wirelessSocketId = $wirelessSocketId;
		$periodicTask->wirelessSocketState = $wirelessSocketState;
		$periodicTask->weekday = $weekday;
		$periodicTask->hour = $hour;
		$periodicTask->minute = $minute;
		$periodicTask->periodic = $periodic;
		$periodicTask->active = $active;
		return $this->generateResponse("success", function () use ($periodicTask) {
			return $this->service->add($periodicTask);
		}, '');
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * 
	 * @param int $id
	 * @param string name
	 * @param int wirelessSocketId
	 * @param int wirelessSocketState
	 * @param int weekday
	 * @param int hour
	 * @param int minute
	 * @param int periodic
	 * @param int active
	 */
	public function update(int $id, string $name, int $wirelessSocketId, int $wirelessSocketState, int $weekday, int $hour, int $minute, int $periodic, int $active)
	{
		$periodicTask = new PeriodicTask();
		$periodicTask->id = $id;
		$periodicTask->name = $name;
		$periodicTask->wirelessSocketId = $wirelessSocketId;
		$periodicTask->wirelessSocketState = $wirelessSocketState;
		$periodicTask->weekday = $weekday;
		$periodicTask->hour = $hour;
		$periodicTask->minute = $minute;
		$periodicTask->periodic = $periodic;
		$periodicTask->active = $active;
		return $this->generateResponse("success", function () use ($periodicTask) {
			return $this->service->update($periodicTask);
		}, '');
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * 
	 * @param int $id
	 */
	public function destroy(int $id)
	{
		return $this->generateResponse("success", function () use ($id) {
			return $this->service->delete($id);
		}, '');
	}
}
