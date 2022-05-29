<?php

declare(strict_types=1);

namespace App\Service\Parsers;

interface WebParserIngerface
{
    public function hostEcceptable(string $url): bool;

    public function parseHtml(string $html): array;
}
