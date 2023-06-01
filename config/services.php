<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autoconfigure()
        ->autowire()
    ;

    $services
        ->load('Codefog\\ElementsFilterBundle\\', __DIR__ . '/../src')
        ->exclude(__DIR__  .'/../src/FilterCollection.php')
    ;
};
