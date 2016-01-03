<?php

namespace AppBundle\Command;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('collision:generate')
            ->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'limit', 100);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $limit = (int)$input->getOption('limit');

        /* @var $connection Connection */
        $connection = $this->getContainer()->get('doctrine')->getConnection();

        $result = $connection->executeQuery("
            REPLACE INTO `md5_map` (`from`, `to`)
            SELECT `to`, MD5(`to`)
            FROM `md5_map`
            WHERE `to` NOT IN (
              SELECT `from` FROM `md5_map`
            )
            LIMIT $limit;
        ");

        $added = $result->rowCount();

        $output->writeln("<info>Added: $added</info>");

        $collisions = $connection->fetchAll('
            SELECT `to`, COUNT(*) FROM `md5_map`
            GROUP BY `to`
            HAVING COUNT(*) > 1;
        ');

        if ($collisions) {
            $count = count($collisions);
            $output->writeln("<info>Find: $count</info>");
        } else {
            $output->writeln("<info>Process</info>");
        }
    }
}
