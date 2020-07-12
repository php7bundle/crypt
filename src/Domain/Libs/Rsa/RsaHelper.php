<?php

namespace PhpBundle\Crypt\Domain\Libs\Rsa;

use PhpBundle\Crypt\Domain\Entities\CertificateSubjectEntity;
use PhpLab\Core\Domain\Helpers\EntityHelper;

class RsaHelper
{

    public static function keyToLine($key) {
        $key = preg_replace('/-----([^-]+)-----/i', '', $key);
        $key = preg_replace('/\s+/i', '', $key);
        return $key;
    }

    public static function subjectArrayToJson(array $subjectArray): string
    {
        $subjectArray['publicKey'] = RsaHelper::keyToLine($subjectArray['publicKey']);
        ksort($subjectArray);
        $subjectJson = json_encode($subjectArray);
        return $subjectJson;
    }

}
