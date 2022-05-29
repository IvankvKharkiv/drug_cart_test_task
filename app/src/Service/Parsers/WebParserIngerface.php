<?php

namespace App\Service\Parsers;

interface WebParserIngerface
{
    public function hostEcceptable(string $url) : bool;
    public function parseHtml(string $html) : array;

}