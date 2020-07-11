<?php

use Illuminate\Container\Container;
use PhpBundle\Crypt\Domain\Libs\Rsa\RsaStore;
use PhpBundle\Crypt\Symfony\Api\CryptModule;
use PhpLab\Core\Enums\Measure\TimeEnum;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Routing\RouteCollection;

/**
 * @var Container $container
 * @var RouteCollection $routeCollection
 */

$articleModule = new CryptModule;
$articleModule->bindContainer($container);
$articleModule->getRouteCollection($routeCollection);

$container->bind(RsaStore::class, function () {
    return new RsaStore(__DIR__ . '/../../../../../../public/rsa');
}, true);
$container->bind(AbstractAdapter::class, function () {
    return new FilesystemAdapter('cryptoSession', TimeEnum::SECOND_PER_DAY, __DIR__ . '/../../../../../../var/cache');
}, true);
