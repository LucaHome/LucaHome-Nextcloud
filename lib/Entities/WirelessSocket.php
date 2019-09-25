<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\WirelessControl\Entities;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class WirelessSocket extends Entity implements JsonSerializable
{
    public $name;
    public $code;
    public $area;
    public $state;
    public $description;
    public $icon;
    public $deletable;
    public $lastToggled;
    public $group;

    public function __construct()
    {
        $this->addType('state', 'integer');
        $this->addType('deletable', 'integer');
        $this->addType('lastToggled', 'integer');
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
            'deletable' => $this->deletable,
            'lastToggled' => $this->lastToggled,
            'group' => $this->group
        ];
    }
}
