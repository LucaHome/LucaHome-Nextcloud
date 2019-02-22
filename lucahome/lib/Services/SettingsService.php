<?php

namespace OCA\LucaHome\Services;

use OCP\IConfig;

class SettingsService implements ISettingsService {
	/**
	 * @var string
	 */
    private $userId;
    
	/**
	 * @var IConfig
	 */
    private $settings;
    
	/**
	 * @var string
	 */
    private $appName;
    
	/**
	 * @param string $userId
	 * @param IConfig $settings
	 * @param string $appName
	 */
	public function __construct(string $userId, IConfig $settings, string $appName) {
		$this->userId = $userId;
		$this->settings = $settings;
		$this->appName = $appName;
    }
    
	/**
	 * Get the current settings
	 *
	 * @return array
	 */
	public function get():array {
		$settings = array(
			'sortOrderArea' => (string)$this->settings->getUserValue($this->userId, $this->appName,'various_sortOrderArea'),
			'sortDirectionArea' => (bool)$this->settings->getUserValue($this->userId, $this->appName,'various_sortDirectionArea'),
			'sortOrderWirelessSocket' => (string)$this->settings->getUserValue($this->userId, $this->appName,'various_sortOrderWirelessSocket'),
			'sortDirectionWirelessSocket' => (bool)$this->settings->getUserValue($this->userId, $this->appName,'various_sortDirectionWirelessSocket'),
			'wirelessSocketGpioPin' => (int)$this->settings->getUserValue($this->userId, $this->appName,'various_wirelessSocketGpioPin'),
			'userID' => $this->userId
		);
		return $settings;
    }
    
	/**
	 * Set setting of type to new value
	 *
	 * @param $setting
	 * @param $value
	 * @return bool
	 */
	public function set($setting, $value):bool {
		$this->settings->setUserValue($this->userId, $this->appName, 'various_'.$setting, $value);
		return true;
	}
}