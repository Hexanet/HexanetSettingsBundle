<?php

namespace spec\Hexanet\SettingsBundle\Entity;

use Hexanet\SettingsBundle\Entity\Setting;
use PhpSpec\ObjectBehavior;

class SettingSpec extends ObjectBehavior
{
    const NAME = 'my_setting';

    public function let()
    {
        $this->beConstructedWith(self::NAME);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Setting::class);
    }

    public function it_returns_name()
    {
        $this->getName()->shouldReturn(self::NAME);
    }

    public function its_value_is_null_by_default()
    {
        $this->getValue()->shouldReturn(null);
    }

    public function its_value_is_mutable()
    {
        $this->setValue('my value');
        $this->getValue()->shouldReturn('my value');
    }
}
