<?php

declare(strict_types=1);

namespace App\Service\Parsers;

use App\Exception\ParserHtmProcessException;
use Symfony\Component\DomCrawler\Crawler;

class RozetkaWebParser implements WebParserIngerface
{
    public const HOST = 'rozetka.com.ua';

    public function hostEcceptable(string $url): bool
    {
        return parse_url($url, PHP_URL_HOST) === $this::HOST;
    }

    public function parseHtml(string $html): array
    {
        try {
            $result = $this->parse($html);
        } catch (\Exception $e) {
            throw new ParserHtmProcessException();
        }

        return $result;
    }

    protected function parse(string $html): array
    {
        $crawler = new Crawler($html);
        $listText = $crawler
            ->filterXPath('descendant-or-self::app-root/div/div/rz-category/div/main/rz-catalog/div/div/section/rz-grid/ul/li')
            ->each(function (Crawler $node, $i) {
                $result[] = $node
                    ->filterXPath('descendant-or-self::rz-catalog-tile/app-goods-tile-default/div/div')
                    ->filter('.goods-tile__title')
                    ->text();

                $result[] = (int) str_replace("\xc2\xa0", '', $node
                    ->filterXPath('descendant-or-self::rz-catalog-tile/app-goods-tile-default/div/div/div/div/p')
                    ->filter('.goods-tile__price-value')
                    ->text());

                $result[] = $node
                    ->filterXPath('descendant-or-self::rz-catalog-tile/app-goods-tile-default/div/div/a')
                    ->filter('img')
                    ->attr('src');

                $result[] = $node
                    ->filterXPath('descendant-or-self::rz-catalog-tile/app-goods-tile-default/div/div')
                    ->filter('a')
                    ->attr('href');

                return $result;
            });

        array_unshift($listText, ['title', 'price', 'image', 'link']);

        return $listText;
    }
}
