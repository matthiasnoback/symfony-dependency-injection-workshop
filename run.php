<?php

require __DIR__  . '/vendor/autoload.php';

use CatApi\CatApi;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Workshop\ContainerFactory;

$factory = new ContainerFactory(__DIR__ . '/cache', __DIR__ . '/config');

$container = $factory->create(function(ContainerBuilder $container, LoaderInterface $loader) {
    // load any configuration file you like
    $loader->load('services.yml');

    // maybe register a compiler pass
    //$container->addCompilerPass(...);
});

$catApi = $container->get('cat_api');

echo 'URL for cat gif with id "vd": ' . $catApi->getCatGifUrl('vd') . "\n";
echo 'A random URL of a cat gif: ' . $catApi->getRandomCatGifUrl() . "\n";
