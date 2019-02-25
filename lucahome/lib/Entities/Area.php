<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\LucaHome\Entities;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Area extends Entity implements JsonSerializable {
    
    public $name;
    public $filter;
    public $deletable;

    public function __construct() {
        $this->addType('deletable', 'integer');
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'filter' => $this->filter,
            'deletable' => $this->deletable
        ];
    }
}
