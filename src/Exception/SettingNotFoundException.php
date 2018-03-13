<?php

namespace Hexanet\SettingsBundle\Exception;

class SettingNotFoundException extends \Exception
{
    /**
     * @param string $name
     *
     * @return SettingNotFoundException
     */
    public static function create(string $name) : SettingNotFoundException
    {
        return new self(sprintf(
            'Setting "%s" not found',
            $name
        ));
    }
}
