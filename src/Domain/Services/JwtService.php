<?php

namespace PhpBundle\Crypt\Domain\Services;

use PhpBundle\Crypt\Domain\Entities\JwtEntity;
use PhpBundle\Crypt\Domain\Helpers\JwtEncodeHelper;
use PhpBundle\Crypt\Domain\Helpers\JwtHelper;
use PhpBundle\Crypt\Domain\Interfaces\Repositories\ProfileRepositoryInterface;
use PhpBundle\Crypt\Domain\Interfaces\Services\JwtServiceInterface;
use PhpBundle\Crypt\Domain\Libs\ProfileContainer;

class JwtService implements JwtServiceInterface
{

    private $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function sign(JwtEntity $jwtEntity, string $profileName): string
    {
        $profileEntity = $this->profileRepository->oneByName($profileName);
        $token = JwtHelper::sign($jwtEntity, $profileEntity);
        return $token;
    }

    public function verify(string $token, string $profileName): JwtEntity
    {
        $profileEntity = $this->profileRepository->oneByName($profileName);
        $jwtEntity = JwtHelper::decode($token, $profileEntity);
        return $jwtEntity;
    }

    public function decode(string $token)
    {
        $jwtEntity = JwtEncodeHelper::decode($token);
        return $jwtEntity;
    }

    public function setProfiles($profiles)
    {
        if (is_array($profiles)) {
            $this->profileContainer = new ProfileContainer($profiles);
        } else {
            $this->profileContainer = $profiles;
        }
    }
}
