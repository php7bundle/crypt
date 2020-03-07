<?php

namespace PhpBundle\Crypt\Domain\Entities;

use PhpBundle\Crypt\Domain\Enums\JwtAlgorithmEnum;

/**
 * Class JwtHeaderEntity
 * @package PhpBundle\Crypt\Domain\Entities
 *
 * @property $typ string
 * @property $alg string
 * @property $kid string
 */
class JwtHeaderEntity
{

    public $typ = 'JWT';
    public $alg = JwtAlgorithmEnum::HS256;
    public $kid;

}
