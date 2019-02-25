<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\LucaHome\Entities;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class WirelessSocket extends Entity implements JsonSerializable {

    protected $name;
    protected $code;
    protected $area;
    protected $state;
    protected $description;
    protected $icon;

    public function __construct() {
        $this->addType('state', 'integer');
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'area' => $this->area,
            'state' => $this->state,
            'description' => $this->description,
            'icon' => $this->icon
        ];
    }
}
