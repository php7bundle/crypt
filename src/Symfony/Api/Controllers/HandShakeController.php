<?php

namespace PhpBundle\Crypt\Symfony\Api\Controllers;

use PhpBundle\Crypt\Domain\Libs\Rsa\Rsa;
use PhpBundle\Crypt\Domain\Libs\Rsa\Session;
use PhpLab\Rest\Base\BaseCrudApiController;
use PhpBundle\Article\Domain\Interfaces\PostServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HandShakeController
{

    private $rsa;
    private $session;

    public function __construct(Rsa $rsa, Session $session)
    {
        $this->rsa = $rsa;
        $this->session = $session;
        if(isset($_SERVER['HTTP_X_CRYPT_SESSION'])) {
            $session->start($_SERVER['HTTP_X_CRYPT_SESSION']);
        }
    }

    public function startSession() {
        $this->session->start();
        return new Response($this->session->getSessionId());
    }

    public function getPublicKey() {
        $key = $this->rsa->getPublicKey();
        return new Response($key);
    }

    public function setSecretKey(Request $request)
    {
        $encriptedKey = $request->getContent();
        $key = $this->rsa->decode($encriptedKey);
        $this->session->set('secretKey', $key);
        //dd($this->session->get('secretKey'));
        return new Response();
    }
}
