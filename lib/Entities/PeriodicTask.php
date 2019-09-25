<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\WirelessControl\Entities;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class PeriodicTask extends Entity implements JsonSerializable
{
    public $name;
    public $wirelessSocketId;
    public $wirelessSocketState;
    public $weekday;
    public $hour;
    public $minute;
    public $periodic;
    public $active;

    public function __construct()
    {
        $this->addType('wirelessSocketId', 'integer');
        $this->addType('wirelessSocketState', 'integer');
        $this->addType('weekday', 'integer');
        $this->addType('hour', 'integer');
        $this->addType('minute', 'integer');
        $this->addType('periodic', 'integer');
        $this->addType('active', 'integer');
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'wirelessSocketId' => $this->wirelessSocketId,
            'wirelessSocketState' => $this->wirelessSocketState,
            'weekday' => $this->weekday,
            'hour' => $this->hour,
            'minute' => $this->minute,
            'periodic' => $this->periodic,
            'active' => $this->active
        ];
    }
}
