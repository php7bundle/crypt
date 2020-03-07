<?php

namespace PhpBundle\Crypt\Domain\Enums;

use PhpLab\Core\Domain\Base\BaseEnum;

class RsaBitsEnum extends BaseEnum
{

    const BIT_512 = 512;
    const BIT_1024 = 1024;
    const BIT_2048 = 2048;
    const BIT_4096 = 4096;

}
