<?php

namespace PhpBundle\Crypt\Domain\Entities;

class CertificateEntity
{

    private $subject;
    private $certifier;
    private $signature;

    public function getSubject(): CertificateSubjectEntity
    {
        return $this->subject;
    }

    public function setSubject(CertificateSubjectEntity $subject): void
    {
        $this->subject = $subject;
    }

    public function getCertifier()
    {
        return $this->certifier;
    }

    public function setCertifier($certifier): void
    {
        $this->certifier = $certifier;
    }

    public function getSignature(): SignatureEntity
    {
        return $this->signature;
    }

    public function setSignature(SignatureEntity $signature): void
    {
        $this->signature = $signature;
    }

}
