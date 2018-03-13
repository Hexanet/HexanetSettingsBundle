<?php

namespace Hexanet\SettingsBundle\Schema;

interface SchemaInterface
{
    /**
     * @param SettingsBuilder $settingsBuilder
     */
    public function build(SettingsBuilder $settingsBuilder) : void;
}
