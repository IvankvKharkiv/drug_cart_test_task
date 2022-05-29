<?php

declare(strict_types=1);

namespace App\Service;

class ParsedPageGeneralFileSaver
{
    public const FILE_PAHT = __DIR__ . '/../../var/result/';

    public function saveGeneralFileFromContentArray($content): bool
    {
        file_put_contents($this::FILE_PAHT . $this->getCurrentFileName(), $content);

        return true;
    }

    private function getCurrentFileName()
    {
        return 'ParsedPageCsvFile' . (new \DateTime())->format('Y_m_d\THis') . '.html';
    }
}
