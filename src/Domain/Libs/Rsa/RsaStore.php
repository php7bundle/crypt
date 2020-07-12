<?php

namespace PhpBundle\Crypt\Domain\Libs\Rsa;

use PhpBundle\Crypt\Domain\Enums\CertificateFormatEnum;
use PhpBundle\Crypt\Domain\Enums\RsaKeyFormatEnum;
use PhpBundle\Crypt\Domain\Libs\Encoders\EncoderInterface;
use PhpLab\Core\Exceptions\NotFoundException;
use PhpLab\Core\Helpers\StringHelper;

class RsaStore extends BaseRsaStore implements RsaStoreInterface
{

    private $dir;

    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    public function getDir() {
        return $this->dir;
    }

    protected function getContent(string $name): string {
        $fileName = $this->dir . '/' . $name;
        if( ! file_exists($fileName)) {
            throw new NotFoundException("Not found $name!");
        }
        $content = file_get_contents($fileName);
        return $content;
    }

    protected function setContent(string $name, string $content) {
        if($this->readOnly) {
            throw new \Exception('Read only!');
        }
        return file_put_contents($this->dir . '/' . $name, $content);
    }

}
