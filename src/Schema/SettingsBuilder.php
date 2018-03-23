<?php

namespace Hexanet\SettingsBundle\Schema;

use Hexanet\SettingsBundle\Manager\SettingsManagerInterface;

class SettingsBuilder
{
    /**
     * @var SettingsManagerInterface
     */
    private $settingsManager;

    /**
     * @var SchemaInterface[]
     */
    private $schemas;

    public function __construct(SettingsManagerInterface $settingsManager, iterable $schemas)
    {
        $this->settingsManager = $settingsManager;

        foreach ($schemas as $schema) {
            $this->schemas[] = $schema;
        }
    }

    public function build() : void
    {
        foreach ($this->schemas as $schema) {
            $schema->build($this);
        }
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function addSetting(string $name, $value)
    {
        if ($this->settingsManager->has($name)) {
            return;
        }

        $this->settingsManager->set($name, $value);
    }
}
