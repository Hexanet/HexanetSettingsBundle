<?php

namespace Hexanet\SettingsBundle\Manager;

use Hexanet\SettingsBundle\Exception\SettingNotFoundException;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class CachedSettingsManager implements SettingsManagerInterface
{
    const ITEM_CACHE_KEY = 'app_settings_manager_item_%s';
    const ALL_CACHE_KEY = 'app_settings_manager_all';
    const EXPIRE_AFTER = '1 day';

    /**
     * @var SettingsManagerInterface
     */
    private $settingsManager;

    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * @param SettingsManagerInterface $settingsManager
     * @param AdapterInterface         $cache
     */
    public function __construct(SettingsManagerInterface $settingsManager, AdapterInterface $cache)
    {
        $this->settingsManager = $settingsManager;
        $this->cache = $cache;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name) : bool
    {
        return $this->settingsManager->has($name);
    }

    /**
     * @param string $name
     *
     * @throws SettingNotFoundException
     *
     * @return mixed
     */
    public function get(string $name)
    {
        $cacheItem = $this->cache->getItem(sprintf(self::ITEM_CACHE_KEY, $name));

        if (!$cacheItem->isHit()) {
            $cacheItem
                ->set($this->settingsManager->get($name))
                ->expiresAfter(\DateInterval::createFromDateString(self::EXPIRE_AFTER));
            $this->cache->save($cacheItem);
        }

        return $cacheItem->get();
    }

    /**
     * @return array
     */
    public function all() : array
    {
        $cacheItem = $this->cache->getItem(self::ALL_CACHE_KEY);

        if (!$cacheItem->isHit()) {
            $cacheItem
                ->set($this->settingsManager->all())
                ->expiresAfter(\DateInterval::createFromDateString(self::EXPIRE_AFTER));
            $this->cache->save($cacheItem);
        }

        return $cacheItem->get();
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return SettingsManagerInterface
     */
    public function set(string $name, $value) : SettingsManagerInterface
    {
        $this->settingsManager->set($name, $value);

        $this->cache->deleteItems([
            self::ALL_CACHE_KEY,
            sprintf(self::ITEM_CACHE_KEY, $name),
        ]);

        return $this;
    }
}
