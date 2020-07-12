<?php

namespace PhpBundle\Crypt\Symfony\Api\Controllers;

use PhpBundle\Crypt\Domain\Enums\HashAlgoEnum;
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
    }

    public function startSession(Request $request) {
        $this->session->start();
        $sessionId = $this->session->getSessionId();
        $certificate = $this->rsa->getPublicKey();
        $timestamp = time();
        $clientRandomKey = $request->request->get('clientRandomKey');
        $dataForSing = $sessionId . $certificate . $clientRandomKey . $timestamp;
        $signatureEntity = $this->rsa->sign($dataForSing, HashAlgoEnum::SHA256);
        return new JsonResponse([
            'sessionId' => $sessionId,
            'certificate' => $certificate,
            'clientRandomKey' => $clientRandomKey,
            'timestamp' => $timestamp,
            'signature' => $signatureEntity->getSignatureBase64(),
            'signatureFormat' => 'base64',
            'signatureAlgorithm' => 'sha256',
        ]);
    }

    public function setSecretKey(Request $request)
    {
        $encryptedSecretKey = $request->request->get('encryptedSecretKey');
        $sessionId = $request->request->get('sessionId');
        $this->session->start($sessionId);
        if(empty($encryptedSecretKey)) {
            return new JsonResponse([
                [
                    'field' => 'encryptedSecretKey',
                    'message' => 'Empty secret key!',
                ],
            ], 422);
        }
        $key = $this->rsa->decode($encryptedSecretKey);
        if(empty($key)) {
            return new JsonResponse([
                [
                    'field' => 'encryptedSecretKey',
                    'message' => 'Decrypt secret key error!',
                ],
            ], 422);
        }
        $this->session->set('secretKey', $key);
        return new Response();
    }

}
