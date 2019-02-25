<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\LucaHome\Entities;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Area extends Entity implements JsonSerializable {
    
    protected $name;
    protected $filter;

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'filter' => $this->filter
        ];
    }
}
