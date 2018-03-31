<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelWriter
{
    var $spreadsheet;
    private $filename;

    private $activeSheet;

    private $currentRow;

    function __construct($filename)
    {
        $this->filename = $filename;
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $this->spreadsheet = $reader->load($this->filename);
        $this->activeSheet = $this->spreadsheet->getActiveSheet();

        $this->currentRow = $this->findRowNumber($this->activeSheet);
    }

    private function findRowNumber($worksheet)
    {
        if ($worksheet->getCellByColumnAndRow(1, 1) != 'nr') {
            $worksheet->setCellValueByColumnAndRow(1, 1, 'nr');
        }
        $row = 2;
        while ($worksheet->getCellByColumnAndRow(1, $row) != '') {
            $row++;
        }
        $worksheet->setCellValueByColumnAndRow(1, $row, $row - 1);
        return $row;
    }

    public function fillRow($dataArray)
    {
        $i = 0;
        foreach ($dataArray as $key => $value) {
            $headertext = $value[0];
            do {
                $i++;
                echo $i;
                $header = $this->activeSheet->getCellByColumnAndRow($i, 1);
                if ($header == '') {
                    $header = $headertext;
                    $this->activeSheet->setCellValueByColumnAndRow($i, 1, $headertext);
                }
            } while ($header != $headertext);
            $this->activeSheet->setCellValueByColumnAndRow($i, $this->currentRow, $_POST[$key]);
        }
    }

    public function saveSpreadSheet()
    {
        $writer = new Xlsx($this->spreadsheet);
        $writer->save($this->filename);
    }
}