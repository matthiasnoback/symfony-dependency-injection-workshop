<?php

namespace CatApi;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterNewUrlObserversCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $realCatApiDefinition = $container->getDefinition('real_cat_api');
        $observers = [];

        foreach ($container->findTaggedServiceIds('cat_api.new_url_observer') as $serviceId => $tags) {
            $observers[] = new Reference($serviceId);
        }

        $realCatApiDefinition->replaceArgument(1, $observers);
    }
}
