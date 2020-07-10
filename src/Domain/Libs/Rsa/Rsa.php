<?php

namespace PhpBundle\Crypt\Domain\Libs\Rsa;

use PhpBundle\Crypt\Domain\Libs\Encoders\EncoderInterface;

class Rsa implements EncoderInterface
{

    private $store;

    public function __construct(RsaStore $store)
    {
        $this->store = $store;
    }

    public function getPublicKey()
    {
        return $this->store->getPublicKey();
    }

    public function encode($data)
    {
        $pKey = openssl_pkey_get_public($this->store->getPublicKey());
        $encrypted = "";
        openssl_public_encrypt($data, $encrypted, $pKey);
        return base64_encode($encrypted);
    }

    public function decode($encrypted)
    {
        $ogp = openssl_get_privatekey($this->store->getPrivateKey());
        $binEncyptedData = base64_decode($encrypted);
        $isSuccess = @openssl_private_decrypt($binEncyptedData, $out, $ogp);
        if(! $isSuccess) {
            throw new \Exception('Decrypt error');
        }
        return $out;
    }








    function privateKeyEncrypt($privateKey, $content)
    {
        $piKey = openssl_pkey_get_private($privateKey);
        $encrypted = "";
        openssl_private_encrypt($content, $encrypted, $piKey);
        return base64_encode($encrypted);
    }
//rsa公钥解密
    function publicKeyDecrypt($publicKey, $content)
    {
        $pKey = openssl_pkey_get_public($publicKey);
        $decrypted = "";
        openssl_public_decrypt($content, $decrypted, $pKey);
        return $decrypted;
    }
//rsa公钥加密
    function publicKeyEncrypt($publicKey, $content)
    {
        $pKey = openssl_pkey_get_public($publicKey);
        $encrypted = "";
        openssl_public_encrypt($content, $encrypted, $pKey);
        return base64_encode($encrypted);
    }
//rsa私钥解密
    function privateKeyDecrypt($privateKey, $content)
    {
        $pKey = openssl_pkey_get_private($privateKey);
        $decrypted = "";
        openssl_private_decrypt($content, $decrypted, $pKey);
        return $decrypted;
    }
}
