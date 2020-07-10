<?php

namespace PhpBundle\Crypt\Domain\Libs\Rsa;

use PhpBundle\Crypt\Domain\Libs\Encoders\EncoderInterface;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\HttpFoundation\Request;

class HandShakeController
{

    private $rsa;
    private $session;

    public function __construct(Rsa $rsa, Session $session)
    {
        $this->rsa = $rsa;
        $this->session = $session;
    }

    public function getPublicKey(Request $request)
    {
        return $this->rsa->getPublicKey();
    }

    public function setSecretKey(Request $request)
    {
        $encriptedKey = $request->getContent();
        $key = $this->rsa->decode($encriptedKey);
        $this->session->set('secretKey', $key);
        //dd($this->session->get('secretKey'));
    }
}
