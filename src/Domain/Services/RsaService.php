<?php

namespace PhpBundle\Crypt\Domain\Services;

use PhpBundle\Crypt\Domain\Entities\CertificateEntity;
use PhpBundle\Crypt\Domain\Entities\CertificateInfoEntity;
use PhpBundle\Crypt\Domain\Entities\CertificateSubjectEntity;
use PhpBundle\Crypt\Domain\Entities\RsaKeyEntity;
use PhpBundle\Crypt\Domain\Entities\SignatureEntity;
use PhpBundle\Crypt\Domain\Enums\CertificateFormatEnum;
use PhpBundle\Crypt\Domain\Enums\HashAlgoEnum;
use PhpBundle\Crypt\Domain\Exceptions\InvalidPasswordException;
use PhpBundle\Crypt\Domain\Interfaces\Services\PasswordServiceInterface;
use PhpBundle\Crypt\Domain\Libs\Rsa\Rsa;
use PhpBundle\Crypt\Domain\Libs\Rsa\RsaHelper;
use PhpBundle\Crypt\Domain\Libs\Rsa\RsaStoreFile;
use PhpBundle\Crypt\Domain\Libs\Rsa\RsaStoreInterface;
use PhpBundle\Crypt\Domain\Libs\Rsa\RsaStoreRam;
use PhpLab\Core\Domain\Helpers\EntityHelper;
use PhpLab\Core\Legacy\Yii\Base\Security;
use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;

class RsaService
{

    public function generatePair(RsaStoreInterface $store, $bits = 2048, string $algo = HashAlgoEnum::SHA256)
    {
        $rsa = new \phpseclib\Crypt\RSA();
        
        $rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
        //$rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS1);

        //define('CRYPT_RSA_EXPONENT', 65537);
        //define('CRYPT_RSA_SMALLEST_PRIME', 64); // makes it so multi-prime RSA is used
        $keys = $rsa->createKey($bits);
        
        $store->setPublicKey($keys['publickey']);
        $store->setPrivateKey($keys['privatekey']);
    }
}
