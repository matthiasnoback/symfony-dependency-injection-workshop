<?php

require __DIR__  . '/vendor/autoload.php';

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

$factory = new \Workshop\ContainerFactory(__DIR__ . '/cache', __DIR__ . '/config');

$container = $factory->create(function(ContainerBuilder $container, LoaderInterface $loader) {
    // load any configuration file you like
    $loader->load('services.yml');

    // maybe register a compiler pass
    //$container->addCompilerPass(...);
});

// use services from the container
var_dump($container->get('test')); exit;
