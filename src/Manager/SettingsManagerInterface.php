<?php

namespace Hexanet\SettingsBundle\Manager;

use Hexanet\SettingsBundle\Exception\SettingNotFoundException;

interface SettingsManagerInterface
{
    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name) : bool;

    /**
     * @param string $name
     *
     * @throws SettingNotFoundException
     *
     * @return mixed
     */
    public function get(string $name);

    /**
     * @return array
     */
    public function all() : array;

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return SettingsManagerInterface
     */
    public function set(string $name, $value) : SettingsManagerInterface;
}
