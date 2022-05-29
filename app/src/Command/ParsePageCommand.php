<?php

namespace App\Command;

use App\Service\Parsers\InternetStorePageParser;
use App\Service\ParsedPageCsvFileSaver;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:parse-page',
    description: 'This command parses page from internet store.',
)]
class ParsePageCommand extends Command
{
    private HttpClientInterface $client;
    private ParsedPageCsvFileSaver $csvFileSaver;
    private InternetStorePageParser $pageParser;

    public function __construct(HttpClientInterface $client, ParsedPageCsvFileSaver $csvFileSaver, InternetStorePageParser $pageParser, string $name = null)
    {
        parent::__construct($name);
        $this->client = $client;
        $this->csvFileSaver = $csvFileSaver;
        $this->pageParser = $pageParser;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('page_url', InputArgument::REQUIRED, 'Inernet store page url for parsing.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $page_url = $input->getArgument('page_url');
        $response = $this->client->request('GET', $page_url);

        $html = $response->getContent();

        try {
            $this->csvFileSaver->saveCsvFileFromContentArray($this->pageParser->parseInternetStorePage($html, $page_url));
        } catch (\Exception $e) {
            $io->error($e->getMessage());
        }


        if ($page_url) {
            $io->note(sprintf('You passed an url: %s', $page_url));
        }


        $io->success('Page Parsed successfuly. Result can be seen in var/result project folder.');

        return Command::SUCCESS;
    }
}