<?php

namespace App\Service\Parsers;

use App\Exception\InvalidWebParserException;

class InternetStorePageParser
{
    private array $webParsers;

    public function __construct(array $webParsers)
    {
        foreach ($webParsers as $webParser){
            if (!($webParser instanceof WebParserIngerface)) {
                throw new InvalidWebParserException();
            }
        }
        $this->webParsers = $webParsers;
    }

    public function parseInternetStorePage(string $html, string $url) : array {
        foreach ($this->webParsers as $webParser) {
            if ($webParser->hostEcceptable($url)) {
                return $webParser->parseHtml($html);
            }
        }
        throw new \Exception('No web parser were found for current interent store host.');
    }

    public function getAvailableHosts(){
        $hosts = [];
        foreach ($this->webParsers as $webParser) {
            $hosts[] = $webParser::HOST;
        }
        return $hosts;
    }


}