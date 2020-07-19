<?php

namespace PhpBundle\Crypt\Domain\Entities;

use PhpBundle\Crypt\Domain\Libs\Rsa\RsaHelper;

class RsaKeyEntity
{

    const PUBLIC_KEY = 'PUBLIC KEY';
    const PRIVATE_KEY = 'PRIVATE KEY';
    const CERTIFICATE = 'CERTIFICATE';

    private $raw;
    private $type;

    public function __construct(string $type, string $raw = null)
    {
        $this->type = $type;
        if($raw) {
            $this->raw = $raw;
        }
    }

    public function getPem(): string
    {
        return RsaHelper::binToPem($this->raw, $this->type);
    }

    public function setPem(string $pem): void
    {
        $this->raw = RsaHelper::pemToBin($pem);
    }

    public function getBase64(): string
    {
        return base64_encode($this->raw);
    }

    public function setBase(string $base64): void
    {
        $this->raw = base64_decode($base64);
    }

    public function getRaw(): string
    {
        return $this->raw;
    }

    public function setRaw(string $raw): void
    {
        $this->raw = $raw;
    }

    public function getType()
    {
        return $this->type;
    }

    /*public function setType($type): void
    {
        $this->type = $type;
    }*/

}
