<?php

/**
 * Help found here: https://github.com/nextcloud/passman/blob/master/lib/BackgroundJob/ExpireCredentials.php
 */

namespace OCA\WirelessControl\Cron;

use OC\BackgroundJob\TimedJob;
use OCA\WirelessControl\Services\PeriodicTaskService;
use OCA\WirelessControl\Services\WirelessSocketService;
use OCP\IConfig;
use OCP\ILogger;

class PeriodicTask extends TimedJob {

	/** 
     * @var PeriodicTaskService 
     * */
    private $periodicTaskService;

	/** 
     * @var WirelessSocketService 
     * */
    private $wirelessSocketService;

	/** 
	 * @var ILogger 
     * */
	private $logger;

	/**
	 * @param PeriodicTaskService $periodicTaskService
	 * @param WirelessSocketService $wirelessSocketService
	 * @param ILogger $logger
	 */
    public function __construct(PeriodicTaskService $periodicTaskService, WirelessSocketService $wirelessSocketService, ILogger $logger) {
        $this->periodicTaskService = $periodicTaskService;
        $this->wirelessSocketService = $wirelessSocketService;
        $this->logger = $logger;

        // Run every 60 seconds
        parent::setInterval(60);
    }

    protected  function run($arguments) {
        // http://us3.php.net/manual/en/function.date.php
        // https://stackoverflow.com/questions/8529656/how-do-i-convert-a-string-to-a-number-in-php

        $currentWeekday = (int) date('N'); // 1 (for Monday) through 7 (for Sunday)
        $currentHour = (int) date('H'); // 00 through 23
        $currentMinute = (int) date('i'); // 00 to 59

        $periodicTasks = $this->periodicTaskService->get();
        
		for ($index = 0; $index < sizeof($periodicTasks); $index++) {
            $periodicTask = $periodicTasks[$index];

            if($periodicTask->getActive() === 1
                && $periodicTask->getWeekday() === $currentWeekday
                && $periodicTask->getHour() === $currentHour
                && $periodicTask->getMinute() === $currentMinute) {
                    $wirelessSocket = $this->wirelessSocketService->getById($periodicTask->getWirelessSocketId());
                    
                    if ($wirelessSocket === NULL) {
                        $this->logger->info('PeriodicTask: run: WirelessSocket does not exist for id '.$wirelessSocketId, ['app' => 'WirelessControl']);
                        $this->periodicTaskService->delete($periodicTask->getId());
                    } else {
                        $wirelessSocket->state = $periodicTask->getWirelessSocketState();

                        $wirelessSocketUpdateResult = $this->wirelessSocketService->update($wirelessSocket);
                        if($wirelessSocketUpdateResult !== 0) {
                            $this->logger->info('PeriodicTask: run: WirelessSocket failed to set state for '.$wirelessSocket, ['app' => 'WirelessControl']);
                        }

                        $periodic = $periodicTask->getPeriodic();
                        if($periodic === 0) {
                            $this->periodicTaskService->delete($periodicTask->getId());
                        }
                    }
            }
        }
    }
}