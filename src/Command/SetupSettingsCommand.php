<?php

namespace Hexanet\SettingsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SetupSettingsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('hexanet:settings:setup')
            ->setDescription('Create the settings with their default value, the existing ones are ignored');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Setup the settings');

        $this->getContainer()->get('hexanet.settings_builder')->build();

        $io->success('The settings have been successfully created');
    }
}
