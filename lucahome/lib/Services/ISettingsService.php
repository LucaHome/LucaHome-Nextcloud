<?php

namespace OCA\LucaHome\Services;

interface ISettingsService {

	/**
	 * @return array Settings
	 */
	public function get();

	/**
	 * @param $setting
	 * @param $value
	 * @return bool success
	 */
	public function set($setting, $value);
}