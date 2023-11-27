<?php

namespace App;

use App\DependencyInjection\FileExtension;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait {
        configureContainer as microKernelTraitConfigureContainer;
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->registerExtension(new FileExtension());
    }

    public function configureContainer(ContainerConfigurator $container, LoaderInterface $loader, ContainerBuilder $builder)
    {
        $this->microKernelTraitConfigureContainer($container, $loader, $builder);

        $container->import($this->getProjectDir().'/config/packages/specific/*.yaml');
    }
}
