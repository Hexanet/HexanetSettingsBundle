<?php

namespace spec\Hexanet\SettingsBundle\Exception;

use PhpSpec\ObjectBehavior;

class SettingNotFoundExceptionSpec extends ObjectBehavior
{
    public function it_is_an_exception()
    {
        $this->shouldHaveType(\Exception::class);
    }

    public function it_can_be_created_with_a_setting_name()
    {
        $this->beConstructedThrough('create', ['my_setting']);

        $this->shouldHaveType(\Exception::class);
        $this->getMessage()->shouldReturn('Setting "my_setting" not found');
    }
}
