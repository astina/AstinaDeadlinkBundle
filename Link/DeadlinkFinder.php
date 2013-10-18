<?php

namespace Astina\Bundle\DeadlinkBundle\Link;

use Symfony\Component\Console\Helper\ProgressHelper;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeadlinkFinder
{
    /**
     * @var LinkSourceInterface[]
     */
    protected $linkSources = array();

    /**
     * @var UrlChecker
     */
    protected $urlChecker;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var OutputInterface
     */
    protected $output;

    public function __construct(UrlChecker $urlChecker, EventDispatcherInterface $dispatcher)
    {
        $this->urlChecker = $urlChecker;
        $this->dispatcher = $dispatcher;
        $this->output = new NullOutput();
    }

    public function addLinkSource(LinkSourceInterface $linkSource)
    {
        $this->linkSources[] = $linkSource;
    }

    public function run()
    {
        if (count($this->linkSources) == 0) {
            $this->output->writeln('No link sources configured');
            return;
        }

        foreach ($this->linkSources as $linkSource) {
            $this->checkLinkSource($linkSource);
        }
    }

    protected function checkLinkSource(LinkSourceInterface $linkSource)
    {
        $this->output->writeln(sprintf('<comment>Checking link source:</comment> <info>%s</info>', get_class($linkSource)));

        $links = $linkSource->getLinks();

        $this->output->writeln(sprintf(' > <info>%d</info> links', count($links)));

        $brokenLinks = array();

        foreach ($links as $link) {

            $this->output->write(str_pad(sprintf(' > <info>%s</info> ', $link->getUrl()), 100, '.') . ' ');

            if ($this->urlChecker->check($link->getUrl())) {
                $this->output->writeln('<comment>ok</comment>');
            } else {
                $brokenLinks[] = $link;
                $this->output->writeln('<error>broken</error>');
            }
        }

        if (($count = count($brokenLinks)) == 0) {
            return;
        }

        $this->output->writeln(sprintf(' > <comment>%d</comment> dead links found', $count));

        $this->dispatcher->dispatch(BrokenLinksEvent::NAME, new BrokenLinksEvent($linkSource, $brokenLinks));
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * @param \Symfony\Component\Console\Helper\ProgressHelper $progressHelper
     */
    public function setProgressHelper($progressHelper)
    {
        $this->progressHelper = $progressHelper;
    }
}