<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\WirelessControl\Entities;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class WirelessSocketLegacy extends Entity implements JsonSerializable
{
    public $name;
    public $code;
    public $area;
    public $state;
    public $description;
    public $icon;
    public $deletable;

    public function __construct()
    {
        $this->addType('state', 'integer');
        $this->addType('deletable', 'integer');
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'area' => $this->area,
            'state' => $this->state,
            'description' => $this->description,
            'icon' => $this->icon,
            'deletable' => $this->deletable
        ];
    }

    public static function fromWirelessSocket(WirelessSocket $wirelessSocket)
    {
        $wirelessSocketLegacy = new WirelessSocketLegacy();

        $wirelessSocketLegacy->id = $wirelessSocket->getId();
        $wirelessSocketLegacy->name = $wirelessSocket->getName();
        $wirelessSocketLegacy->code = $wirelessSocket->getCode();
        $wirelessSocketLegacy->area = $wirelessSocket->getArea();
        $wirelessSocketLegacy->state = $wirelessSocket->getState();
        $wirelessSocketLegacy->description = $wirelessSocket->getDescription();
        $wirelessSocketLegacy->icon = $wirelessSocket->getIcon();
        $wirelessSocketLegacy->deletable = $wirelessSocket->getDeletable();

        return $wirelessSocketLegacy;
    }

    public static function toWirelessSocket(WirelessSocketLegacy $wirelessSocketLegacy)
    {
        $wirelessSocket = new WirelessSocket();

        $wirelessSocket->id = $wirelessSocketLegacy->getId();
        $wirelessSocket->name = $wirelessSocketLegacy->getName();
        $wirelessSocket->code = $wirelessSocketLegacy->getCode();
        $wirelessSocket->area = $wirelessSocketLegacy->getArea();
        $wirelessSocket->state = $wirelessSocketLegacy->getState();
        $wirelessSocket->description = $wirelessSocketLegacy->getDescription();
        $wirelessSocket->icon = $wirelessSocketLegacy->getIcon();
        $wirelessSocket->deletable = $wirelessSocketLegacy->getDeletable();
        $wirelessSocket->lastToggled = time();
        $wirelessSocket->group = '';

        return $wirelessSocket;
    }
}
