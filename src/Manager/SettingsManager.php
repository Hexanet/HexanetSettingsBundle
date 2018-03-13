<?php

namespace Hexanet\SettingsBundle\Manager;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Hexanet\SettingsBundle\Entity\Setting;
use Hexanet\SettingsBundle\Exception\SettingNotFoundException;

class SettingsManager implements SettingsManagerInterface
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name) : bool
    {
        return $this->getSetting($name) !== null;
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
        $setting = $this->getSetting($name);

        if (!$setting) {
            throw SettingNotFoundException::create($name);
        }

        return $setting->getValue();
    }

    /**
     * @return array
     */
    public function all() : array
    {
        $settings = $this->getManager()->createQueryBuilder()
            ->select('s.name, s.value')
            ->from(Setting::class, 's')
            ->getQuery()
            ->getArrayResult();

        return array_column($settings, 'value', 'name');
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return SettingsManagerInterface
     */
    public function set(string $name, $value) : SettingsManagerInterface
    {
        $setting = $this->getSetting($name);

        if (!$setting) {
            $setting = new Setting(
                $name,
                $value
            );
        }

        $setting->setValue($value);

        $this->getManager()->persist($setting);
        $this->getManager()->flush($setting);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Setting|null
     */
    private function getSetting(string $name) : ? Setting
    {
        return $this->getManager()->createQueryBuilder()
            ->select('s')
            ->from(Setting::class, 's')
            ->where('s.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return EntityManager
     */
    private function getManager() : EntityManager
    {
        return $this->managerRegistry->getManagerForClass(Setting::class);
    }
}
