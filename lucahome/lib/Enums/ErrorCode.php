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
    const WirelessSocketNameAlreadyInUse = -105;
    const WirelessSocketDbCreateError = -106;
    const WirelessSocketDbUpdateError = -107;
    const WirelessSocketDoesNotExist = -108;

    const InvalidUser = -200;
    const InvalidUserNull = -201;
    const UserDoesNotExist = -202;
}
