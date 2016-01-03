<?php

namespace AppBundle\Command;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SeedCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('collision:seed')
            ->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'limit', 100);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $limit = (int)$input->getOption('limit');

        /* @var $connection Connection */
        $connection = $this->getContainer()->get('doctrine')->getConnection();

        $start = microtime(true);

        $values = [];
        for ($i = 0; $i < $limit; ++$i) {
            $from = $start + $i;
            $values[] = "($from, MD5($from))";
        }
        $values = join(',', $values);

        $result = $connection->executeQuery("
            REPLACE INTO `md5_map` (`from`, `to`)
            VALUES $values;
        ");

        $added = $result->rowCount();

        $output->writeln("<info>Added: $added</info>");
    }
}
