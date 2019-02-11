<?php

namespace OCA\LucaHome\Adapter;

interface IPiAdapter {

	/**
     * @param int gpio
     * @param string code
     * @param int state
	 * @return string Response
	 */
	public function send433MHz(int $gpio, string $code, int $state);
}