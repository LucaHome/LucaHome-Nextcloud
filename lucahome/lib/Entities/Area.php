<?php

/**
 * Helpful: https://docs.nextcloud.com/server/stable/developer_manual/app/storage/database.html
 */

namespace OCA\LucaHome\Entities;

use \OCP\AppFramework\Db\Entity;

class Area extends Entity {
    protected $name;
    protected $filter;
}
