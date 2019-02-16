<?php

/**
 * Helpful: https://stackoverflow.com/questions/254514/php-and-enumerations
 */

namespace OCA\LucaHome\Enums;

abstract class ErrorCode {
    const NoError = 0;
    
    const NoDefintion = -1;

    const WirelessSocketCodeAlreadyInUse = -100;
    const WirelessSocketNameTooLong = -101;
    const WirelessSocketCodeLengthInvalid = -102;
    const WirelessSocketAreaTooLong = -103;
    const WirelessSocketDescriptionTooLong = -104;
    const WirelessSocketNameAlreadyInUse = -105;
    const WirelessSocketDbCreateError = -106;
    const WirelessSocketDbUpdateError = -107;
    const WirelessSocketDoesNotExist = -108;
    const WirelessSocketFailedToToggle = -109;

    const InvalidUser = -200;
    const InvalidUserNull = -201;
    const UserDoesNotExist = -202;

    const AreaNameAlreadyInUse = -300;
    const AreaFilterAlreadyInUse = -301;
    const AreaNameTooLong = -302;
    const AreaFilterTooLong = -303;
    const AreaDbCreateError = -304;
    const AreaDbUpdateError = -305;
    const AreaDoesNotExist = -306;
}
