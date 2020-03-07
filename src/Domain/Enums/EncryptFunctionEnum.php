<?php

namespace PhpBundle\Crypt\Domain\Enums;

use PhpLab\Core\Domain\Base\BaseEnum;

class EncryptFunctionEnum extends BaseEnum
{

    const HASH_HMAC = 'hash_hmac';
    const OPENSSL = 'openssl';

}
