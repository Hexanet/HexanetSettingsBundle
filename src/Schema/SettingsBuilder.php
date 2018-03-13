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

    /**
     * @param SettingsManagerInterface $settingsManager
     */
    public function __construct(SettingsManagerInterface $settingsManager)
    {
        $this->settingsManager = $settingsManager;
        $this->schemas = [];
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

    /**
     * @param SchemaInterface $schema
     */
    public function addSchema(SchemaInterface $schema) : void
    {
        $this->schemas[] = $schema;
    }
}
