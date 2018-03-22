<?php

namespace Hexanet\SettingsBundle\Command;

use Hexanet\SettingsBundle\Schema\SettingsBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SetupSettingsCommand extends Command
{
    protected static $defaultName = 'hexanet:settings:setup';

    /**
     * @var SettingsBuilder
     */
    private $settingsBuilder;

    public function __construct(SettingsBuilder $settingsBuilder)
    {
        $this->settingsBuilder = $settingsBuilder;

        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this->setDescription('Create the settings with their default value, the existing ones are ignored');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Setup the settings');

        $this->settingsBuilder->build();

        $io->success('The settings have been successfully created');
    }
}
