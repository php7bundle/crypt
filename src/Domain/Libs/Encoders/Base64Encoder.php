<?php

namespace PhpBundle\Crypt\Domain\Libs\Encoders;

use PhpBundle\Crypt\Domain\Helpers\SafeBase64Helper;

class Base64Encoder implements EncoderInterface
{

    public function encode($data)
    {
        return SafeBase64Helper::encode($data);
    }

    public function decode($encodedData)
    {
        return SafeBase64Helper::decode($encodedData);
    }

}
