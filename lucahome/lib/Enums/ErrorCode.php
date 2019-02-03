<?php

/**
 * Helpful: https://stackoverflow.com/questions/254514/php-and-enumerations
 */

namespace OCA\LucaHome\Enums;

abstract class ErrorCode {
    const NoError = 0;

    const WirelessSocketCodeAlreadyInUse = -100;
    const WirelessSocketNameTooLong = -101;
    const WirelessSocketCodeLengthInvalid = -102;
    const WirelessSocketAreaTooLong = -103;
    const WirelessSocketDescriptionTooLong = -104;
}
