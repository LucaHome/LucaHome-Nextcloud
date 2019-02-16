<?php
namespace OCA\LucaHome\BackgroundJobs;

use OC\BackgroundJob\TimedJob;
use OCP\AppFramework\Utility\ITimeFactory;
use OCP\IConfig;
use OCP\IUserManager;
use OCP\IUserSession;

class TemperatureJob extends TimedJob {
	public function __construct(
		ITimeFactory $time,
		IConfig $settings,
		IUserManager $userManager,
		IUserSession $userSession
	) {
		$this->settings = $settings;
		$this->userManager = $userManager;
		$this->userSession = $userSession;

		$this->setInterval(5); // Every 5 minutes
	}

	protected function run($argument) {
		if ($this->settings->getAppValue('core', 'backgroundjobs_mode') !== 'cron') {
			return;
		}
		\OCP\Util::writeLog('lucahome', 'starting TemperatureJob', \OCP\Util::WARN);
		
		// TODO Check temperature and send mail while out of normal range
		// => add settings to add range for valid temperature
	}
}