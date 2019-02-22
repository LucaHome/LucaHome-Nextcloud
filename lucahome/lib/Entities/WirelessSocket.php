<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\LucaHome\Entities;

use \OCP\AppFramework\Db\Entity;

class WirelessSocket extends Entity {

    protected $name;
    protected $code;
    protected $area;
    protected $state;
    protected $description;
    protected $icon;

    public function __construct() {
        $this->addType('state', 'integer');
    }
}
