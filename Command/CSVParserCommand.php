<?php

namespace App\CSVParserBundle\Command;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;
use App\CSVParserBundle\Service\Parser;
use App\CSVParserBundle\Service\Helper;



class CSVParserCommand extends Command
{
    protected static $defaultName = 'CSVparser:parse';
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Parse a CSV.')
            ->setHelp('This command allows you to parse a CSV file.')
            ->addArgument('path', InputArgument::OPTIONAL, 'The path of the file.')
            ->addOption('json', null, InputOption::VALUE_OPTIONAL, 'Output a json', true);
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {

        $parser = new Parser();
        $helper = new Helper();
        $path = $input->getArgument('path') !== null ? $input->getArgument('path') : "https://recrutement.dnd.fr/products.csv";
        $array = $helper->reformateArray($parser->parseCSV($path));
        if($input->getOption('json')){
            $response = new Table($output);
            $response->setHeaders($array[0]);
            unset($array[0]);
            $response->setRows($array);
            $response->render();
        }
        else {
            unset($array[0]);
            $output->writeln(json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        return Command::SUCCESS;
    }
}
