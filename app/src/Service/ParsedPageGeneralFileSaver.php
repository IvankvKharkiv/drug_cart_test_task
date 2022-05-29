<?php

namespace App\Service;


class ParsedPageGeneralFileSaver
{
    const FILE_PAHT = __DIR__ . '/../../var/result/';

    public function saveGeneralFileFromContentArray ($content):bool {

        file_put_contents($this::FILE_PAHT . $this->getCurrentFileName() , $content);
        return true;
    }

    private function getCurrentFileName(){
        return 'ParsedPageCsvFile' . (new \DateTime())->format('Y_m_d\THis') . '.html';
    }

}