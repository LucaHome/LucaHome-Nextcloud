<?php

namespace OCA\LucaHome\Adapter;

use OCP\ILogger;

class PiAdapter implements IPiAdapter {

    /** @var int */
    private $receiverPort = 2302;

	/** @var ILogger */
	private $logger;

	public function __construct(ILogger $logger) {
		$this->logger = $logger;
    }
    
	/**
	 * @brief sends command to cpp server
     * @param int gpio
     * @param string code
     * @param int state
	 * @return string Response
	 */
	public function send433MHz(int $gpio, string $code, int $state) {
        return $this->sendMessage("WSO:$gpio:$code:$state");
    }

	/**
	 * @brief sends message to cpp server
     * @param string message
	 * @return string Response
	 */
    private function sendMessage(string $message) {
        $socket = fsockopen ( 'udp://127.0.0.1', $this->receiverPort, $errno, $errstr, 10 );
        if (! $socket) {
            return "$errstr ($errno)";
        } else {
            $out = "";
            fwrite ( $socket, "$data" );
            $out = fread ( $socket, 65536 );
            fclose ( $socket );
            return $out;
        }
    }
}