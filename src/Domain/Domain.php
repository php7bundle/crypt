<?php

namespace PhpBundle\Crypt\Domain;

use PhpLab\Core\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'crypt';
    }


}

