<?php

namespace spec\Hexanet\SettingsBundle\Manager;

use Doctrine\Common\Persistence\ManagerRegistry;
use Hexanet\SettingsBundle\Manager\SettingsManager;
use Hexanet\SettingsBundle\Manager\SettingsManagerInterface;
use PhpSpec\ObjectBehavior;

class SettingsManagerSpec extends ObjectBehavior
{
    public function let(ManagerRegistry $registry)
    {
        $this->beConstructedWith($registry);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SettingsManager::class);
    }

    public function it_implements_settings_manager_interface()
    {
        $this->shouldImplement(SettingsManagerInterface::class);
    }
}
