<?php

namespace App\Service\Parsers;

use App\Exception\ParserHtmProcessException;
use Symfony\Component\DomCrawler\Crawler;

class RepkaWebParser implements WebParserIngerface
{
    const HOST = 'repka.ua';

    public function hostEcceptable(string $url): bool
    {
        return parse_url($url, PHP_URL_HOST) === $this::HOST;
    }


    public function parseHtml(string $html) : array{
        try {
            $result = $this->parse($html);
        } catch (\Exception $e){
            throw new ParserHtmProcessException();
        }
        return $result;
    }

    protected function parse(string $html) : array {
        $crawler = new Crawler($html);

        $listText = $crawler
            ->filterXPath('descendant-or-self::body/div/main/div/div/div[contains(@id, "pagination-content")]/div/ol/li')
            ->each(function (Crawler $node, $i) {

                if ($node->attr('class') !== 'item product product-item'){
                    return null;
                }

                $result [] = $node
                    ->filter('.product-item-name')
                    ->text();

                try {
                    $result [] = (int) mb_ereg_replace('грн', '', str_replace("\xc2\xa0", '', $node
                        ->filter('.special-price >span')
                        ->filterXPath('descendant-or-self::span')
                        ->text()));
                }catch (\Exception $e){
                    $result [] = (int) mb_ereg_replace('грн', '', str_replace("\xc2\xa0", '', $node
                        ->filter('.price >span')
                        ->text()));
                }

                $result [] = $node
                    ->filterXPath('descendant-or-self::div/a')
                    ->filter('img')
                    ->attr('data-src');

                $result [] = $node
                    ->filter('.product-item-name')
                    ->filter('a')
                    ->attr('href');

                return $result;
            });

        array_unshift($listText, ['title', 'price', 'image', 'link']);

        return $listText;
    }

}