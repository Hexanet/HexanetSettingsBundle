<?php

namespace spec\Hexanet\SettingsBundle\Manager;

use Hexanet\SettingsBundle\Manager\CachedSettingsManager;
use Hexanet\SettingsBundle\Manager\SettingsManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class CachedSettingsManagerSpec extends ObjectBehavior
{
    public function let(SettingsManagerInterface $manager, AdapterInterface $cache)
    {
        $this->beConstructedWith($manager, $cache);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CachedSettingsManager::class);
    }

    public function it_implements_settings_manager_interface()
    {
        $this->shouldImplement(SettingsManagerInterface::class);
    }

    public function it_always_checks_if_setting_exists_from_decorated_manager($manager)
    {
        $manager->has('my_setting')->willReturn(true);

        $this->has('my_setting')->shouldReturn(true);
    }

    public function it_returns_setting_from_cache($manager, $cache, CacheItemInterface $cacheItem)
    {
        $settingName = 'my_setting';
        $settingValue = 'my_setting_value';

        $cache->getItem(sprintf(CachedSettingsManager::ITEM_CACHE_KEY, $settingName))->willReturn($cacheItem);
        $cacheItem->isHit()->willReturn(true);
        $cacheItem->get()->willReturn($settingValue);

        $this->get($settingName)->shouldReturn($settingValue);

        $manager->get($settingName)->shouldNotHaveBeenCalled();
    }

    public function it_returns_setting_from_decorated_manager_and_update_cache_if_there_is_no_cache($manager, $cache, CacheItemInterface $cacheItem)
    {
        $settingName = 'my_setting';
        $settingValue = 'my_setting_value';

        $manager->get($settingName)->willReturn($settingValue);

        $cache->getItem(sprintf(CachedSettingsManager::ITEM_CACHE_KEY, $settingName))->willReturn($cacheItem);

        $cacheItem->isHit()->willReturn(false);
        $cacheItem->set($settingValue)->willReturn($cacheItem);
        $cacheItem->get()->willReturn($settingValue);
        $cacheItem->expiresAfter(Argument::type(\DateInterval::class))->willReturn($cacheItem);

        $cache->save($cacheItem)->shouldBeCalled();

        $this->get($settingName)->shouldReturn($settingValue);
    }

    public function it_returns_all_settings_from_cache($manager, $cache, CacheItemInterface $cacheItem)
    {
        $settings = ['my_setting_name' => 'my_setting_value'];

        $cache->getItem(CachedSettingsManager::ALL_CACHE_KEY)->willReturn($cacheItem);
        $cacheItem->isHit()->willReturn(true);
        $cacheItem->get()->willReturn($settings);

        $this->all()->shouldReturn($settings);

        $manager->all()->shouldNotHaveBeenCalled();
    }

    public function it_returns_all_settings_from_decorated_manager_and_update_cache_if_there_is_no_cache($manager, $cache, CacheItemInterface $cacheItem)
    {
        $settings = ['my_setting_name' => 'my_setting_value'];

        $manager->all()->willReturn($settings);

        $cache->getItem(CachedSettingsManager::ALL_CACHE_KEY)->willReturn($cacheItem);

        $cacheItem->isHit()->willReturn(false);
        $cacheItem->set($settings)->willReturn($cacheItem);
        $cacheItem->get()->willReturn($settings);
        $cacheItem->expiresAfter(Argument::type(\DateInterval::class))->willReturn($cacheItem);

        $cache->save($cacheItem)->shouldBeCalled();

        $this->all()->shouldReturn($settings);
    }

    public function it_sets_setting_and_remove_cache($manager, $cache)
    {
        $settingName = 'my_setting_name';
        $settingValue = 'my_new_setting_value';

        $manager->set($settingName, $settingValue)->shouldBeCalled();

        $cache->deleteItems(Argument::allOf(
            Argument::containing(sprintf(CachedSettingsManager::ITEM_CACHE_KEY, $settingName)),
            Argument::containing(CachedSettingsManager::ALL_CACHE_KEY)
        ))->shouldBeCalled();

        $this->set($settingName, $settingValue);
    }
}
