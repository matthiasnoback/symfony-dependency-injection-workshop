<?php

namespace Workshop;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ContainerFactory
{
    private $cacheDir;
    private $configDir;

    public function __construct($cacheDir, $configDir)
    {
        $this->cacheDir = $cacheDir;
        $this->configDir = $configDir;
    }

    /**
     * @return ContainerInterface
     */
    public function create($loadCallable)
    {
        $container = new ContainerBuilder();

        // create a service definition file loader for .yml files
        $loader = new YamlFileLoader($container, new FileLocator($this->configDir));

        // allow the client to load service definition files, add compiler passes, etc.
        $loadCallable($container, $loader);

        // compile the container (i.e. run compiler passes)
        $container->compile();

        // dump the container as executable PHP code
        $dumpedContainerFile = $this->cacheDir . '/container.php';
        $dumper = new PhpDumper($container);
        file_put_contents(
            $dumpedContainerFile,
            $dumper->dump()
        );

        // load the container
        require $dumpedContainerFile;

        return new \ProjectServiceContainer();
    }
}
