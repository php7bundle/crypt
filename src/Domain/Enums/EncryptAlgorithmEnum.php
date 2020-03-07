<?php

namespace PhpBundle\Crypt\Domain\Enums;

use PhpLab\Core\Domain\Base\BaseEnum;

class EncryptAlgorithmEnum extends BaseEnum
{

    const SHA256 = 'SHA256';
    const SHA512 = 'SHA512';
    const SHA384 = 'SHA384';

}
