<?php

namespace Astina\Bundle\DeadlinkBundle\Command;

use Astina\Bundle\DeadlinkBundle\Link\DeadlinkFinder;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckLinksCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('astina:deadlink:check')
            ->setDescription('Checks link sources for dead links')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var DeadlinkFinder $deadlinkFinder */
        $deadlinkFinder = $this->getContainer()->get('astina_deadlink.deadlink_finder');
        $deadlinkFinder->setOutput($output);
        $deadlinkFinder->run();
    }
}