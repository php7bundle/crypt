<?php

namespace PhpBundle\Crypt\Domain\Libs\Encoders;

interface EncoderInterface
{

    public function encode($data);
    public function decode($encodedData);

}