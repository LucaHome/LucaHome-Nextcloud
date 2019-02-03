<?php

/**
 * Helpful: https://stackoverflow.com/questions/254514/php-and-enumerations
 */

namespace OCA\LucaHome\Enums;

abstract class ErrorCode {
    const NoError = 0;
    const WirelessSocketCodeAlreadyInUse = -100;
}
