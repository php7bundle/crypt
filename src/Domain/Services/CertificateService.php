<?php

namespace PhpBundle\Crypt\Domain\Services;

use PhpBundle\Crypt\Domain\Entities\CertificateEntity;
use PhpBundle\Crypt\Domain\Entities\CertificateInfoEntity;
use PhpBundle\Crypt\Domain\Entities\CertificateSubjectEntity;
use PhpBundle\Crypt\Domain\Entities\SignatureEntity;
use PhpBundle\Crypt\Domain\Enums\CertificateFormatEnum;
use PhpBundle\Crypt\Domain\Enums\HashAlgoEnum;
use PhpBundle\Crypt\Domain\Exceptions\InvalidPasswordException;
use PhpBundle\Crypt\Domain\Interfaces\Services\PasswordServiceInterface;
use PhpBundle\Crypt\Domain\Libs\Rsa\Rsa;
use PhpBundle\Crypt\Domain\Libs\Rsa\RsaHelper;
use PhpBundle\Crypt\Domain\Libs\Rsa\RsaStore;
use PhpBundle\Crypt\Domain\Libs\Rsa\RsaStoreRam;
use PhpLab\Core\Domain\Helpers\EntityHelper;
use PhpLab\Core\Legacy\Yii\Base\Security;
use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;

class CertificateService
{

    public function make(RsaStore $certifierStore, CertificateSubjectEntity $subjectEntity, string $algo = HashAlgoEnum::SHA256): string
    {
        $subjectArray = EntityHelper::toArray($subjectEntity);
        $subjectJson = RsaHelper::subjectArrayToJson($subjectArray);
        $rsa = new Rsa($certifierStore);
        $signatureEntity = $rsa->sign($subjectJson, $algo);
        $arr = [
            'subject' => $subjectArray,
            'signature' => [
                'signature' => $signatureEntity->getSignatureBase64(),
                'format' => 'base64',
                'algorithm' => 'sha256',
            ],
        ];
        if($subjectEntity->getPublicKey() == $certifierStore->getPublicKey()) {
            $arr['certifier'] = 'self';
        } else {
            $arr['certifier'] = $certifierStore->getCertificate(CertificateFormatEnum::ARRAY);
        }
        return json_encode($arr, JSON_PRETTY_PRINT);
    }

    public function verify(string $cert): bool
    {
        $certArray = json_decode($cert, true);
        $subjectArray = $certArray['subject'];
        $subjectJson = RsaHelper::subjectArrayToJson($subjectArray);
        if($certArray['certifier'] == 'self') {
            $certifierPublicKey = $certArray['subject']['publicKey'];
        } else {
            $certifierPublicKey = $certArray['certifier']['subject']['publicKey'];
        }
        $store = new RsaStoreRam('');
        $store->setPublicKey($certifierPublicKey);
        $rsa = new Rsa($store);

        $signatureEntity = new SignatureEntity;
        $signatureEntity->setSignatureBase64($certArray['signature']['signature']);
        $signatureEntity->setAlgorithm($certArray['signature']['algorithm']);
        $isVerify = $rsa->verify($subjectJson, $signatureEntity);
        if($isVerify) {
            $diff = intval($certArray['subject']['expireAt']) - time();
            if($diff < 1) {
                return false;
            }
        }
        return $isVerify;
    }
}
