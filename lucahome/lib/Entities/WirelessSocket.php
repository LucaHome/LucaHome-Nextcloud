<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\LucaHome\Entities;

use OCP\AppFramework\Db\Entity;

class WirelessSocket extends Entity {

    protected $name;
    protected $code;
    protected $area;
    protected $state;

    protected $userId;
    protected $description;
    protected $public;
    protected $added;
    protected $lastmodified;
    protected $clickcount;

    public function __construct() {
        $this->addType('state', 'integer');
        $this->addType('public', 'integer');
        $this->addType('added', 'integer');
        $this->addType('lastmodified', 'integer');
        $this->addType('clickcount', 'integer');
    }
}
