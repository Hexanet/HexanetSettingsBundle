<?php

namespace spec\Hexanet\SettingsBundle\Schema;

use Hexanet\SettingsBundle\Manager\SettingsManagerInterface;
use Hexanet\SettingsBundle\Schema\SchemaInterface;
use Hexanet\SettingsBundle\Schema\SettingsBuilder;
use PhpSpec\ObjectBehavior;

class SettingsBuilderSpec extends ObjectBehavior
{
    public function let(SettingsManagerInterface $settingsManager)
    {
        $this->beConstructedWith($settingsManager);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SettingsBuilder::class);
    }

    public function it_does_not_create_setting_if_exists(SettingsManagerInterface $settingsManager)
    {
        $settingName = 'my_setting';
        $settingValue = 1.90;

        $settingsManager->has($settingName)->willReturn(true);
        $settingsManager->set($settingName, $settingValue)->shouldNotBeCalled();

        $this->addSetting($settingName, $settingValue);
    }

    public function it_creates_setting_if_not_exists(SettingsManagerInterface $settingsManager)
    {
        $settingName = 'my_setting';
        $settingValue = 'my value';

        $settingsManager->has($settingName)->willReturn(false);
        $settingsManager->set($settingName, $settingValue)->shouldBeCalled();

        $this->addSetting($settingName, $settingValue);
    }

    public function it_builds_the_settings_from_schemas(SchemaInterface $schema)
    {
        $schema->build($this)->shouldBeCalled();
        $this->addSchema($schema);

        $this->build();
    }
}
