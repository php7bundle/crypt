<?php

namespace PhpBundle\Crypt\Domain\Repositories\Config;

use PhpBundle\Crypt\Domain\Interfaces\Repositories\ProfileRepositoryInterface;
use PhpLab\Core\Domain\Helpers\EntityHelper;
use PhpLab\Core\Enums\Measure\TimeEnum;
use PhpBundle\Crypt\Domain\Entities\JwtProfileEntity;
use PhpBundle\Crypt\Domain\Entities\KeyEntity;
use PhpLab\Core\Libs\Env\DotEnvHelper;

class ProfileRepository implements ProfileRepositoryInterface
{

    public function oneByName(string $profileName)
    {
        $prifile = DotEnvHelper::get('jwt.profiles.' . $profileName);
        $keyEntity = new KeyEntity;
        EntityHelper::setAttributes($keyEntity, $prifile['key']);
        $profileEntity = new JwtProfileEntity;
        $profileEntity->name = $profileName;
        $profileEntity->key = $keyEntity;
        $profileEntity->life_time = $prifile['life_time'] ?? TimeEnum::SECOND_PER_YEAR;
        return $profileEntity;
    }

}