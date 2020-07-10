<?php

namespace PhpBundle\Crypt\Domain\Libs\Rsa;

use PhpBundle\Crypt\Domain\Libs\Encoders\EncoderInterface;

class RsaStore implements EncoderInterface
{

    const PRIVATE_KEY_FILE = 'priv.rsa';
    const PUBLIC_KEY_FILE = 'pub.rsa';

    const RSA_FORMAT_TEXT = 'RSA_FORMAT_TEXT';
    const RSA_FORMAT_BIN = 'RSA_FORMAT_BIN';

    private $dir;

    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    public function getPublicKey(string $format = self::RSA_FORMAT_TEXT)
    {
        $key = $this->getContent(self::PUBLIC_KEY_FILE);
        if($format == self::RSA_FORMAT_BIN) {
            $key = openssl_pkey_get_public($key);
        }
        return $key;
    }

    public function getPrivateKey(string $format = self::RSA_FORMAT_TEXT)
    {
        $key = $this->getContent(self::PRIVATE_KEY_FILE);
        if($format == self::RSA_FORMAT_BIN) {
            $ogp = openssl_get_privatekey($this->privateKey);
        }
        return $key;
    }

    private function getContent($name) {
        return file_get_contents($this->dir . '/' . $name);
    }

    public function encode($data)
    {
        $pKey = openssl_pkey_get_public($this->publicKey);
        $encrypted = "";
        openssl_public_encrypt($data, $encrypted, $pKey);
        return base64_encode($encrypted);
    }

    public function decode($encrypted)
    {
        $ogp = openssl_get_privatekey($this->privateKey);
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
