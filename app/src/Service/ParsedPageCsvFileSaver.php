<?php

declare(strict_types=1);

namespace App\Service;

class ParsedPageCsvFileSaver
{
    public const FILE_PAHT = __DIR__ . '/../../var/result/';

    public function saveCsvFileFromContentArray(array $content): bool
    {
        if (count($content) === 0) {
            throw new \Exception();
        }

        $fp = fopen($this::FILE_PAHT . $this->getCurrentFileName(), 'w');
        foreach ($content as $fields) {
            if (is_array($fields)) {
                fputcsv($fp, $fields);
            }
        }

//        file_put_contents($this::FILE_PAHT . $this->getCurrentFileName() , $content);
        return true;
    }

    private function getCurrentFileName()
    {
        return 'ParsedPageCsvFile' . (new \DateTime())->format('Y_m_d\THis') . '.csv';
    }
}
