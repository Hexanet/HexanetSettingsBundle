<?php

namespace Hexanet\SettingsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterSchemasPass implements CompilerPassInterface
{
    const SERVICE_ID = 'hexanet.settings_builder';
    const TAG = 'hexanet.settings_schema';

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::SERVICE_ID)) {
            throw new \LogicException('SettingsBuilder is missing');
        }

        $schemaBuilder = $container->getDefinition(self::SERVICE_ID);

        foreach ($container->findTaggedServiceIds(self::TAG) as $id => $attributes) {
            $schemaBuilder->addMethodCall('addSchema', [new Reference($id)]);
        }
    }
}
