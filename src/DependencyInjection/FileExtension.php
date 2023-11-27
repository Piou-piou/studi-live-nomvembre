<?php

namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class FileExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        foreach ($configs as $config) {
            $container->setParameter('file_upload.enabled', $config['enabled'] ?? false);
            $container->setParameter('file_upload.thumbnails', $config['thumbnails'] ?? []);
            $container->setParameter('file_upload.thumbnails.enabled', $config['thumbnails']['enabled'] ?? false);
            $container->setParameter('file_upload.thumbnails.size', $config['thumbnails']['size'] ?? 0);
            $container->setParameter('file_upload.thumbnails.height', $config['thumbnails']['height'] ?? 0);
        }
    }

    public function getAlias(): string
    {
        return 'file_upload';
    }
}
