<?php

namespace App\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class FileConfiguration implements ConfigurationInterface
{

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('file_upload');
        $root = $builder->getRootNode();

        $root
            ->canBeEnabled()
            ->children()
                ->arrayNode('thumbnails')
                    ->canBeEnabled()
                    ->children()
                        ->integerNode('height')->end()
                        ->integerNode('size')->end()
                    ->end()
                ->end()
            ->end();

        return  $builder;
    }
}
