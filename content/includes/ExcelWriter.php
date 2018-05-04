<?php

/* https://phpspreadsheet.readthedocs.io/en/develop/
 * Install using
 * # composer require phpoffice/phpspreadsheet
 * (in the current directory)
 */

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
        if (file_exists($this->filename)) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $this->spreadsheet = $reader->load($this->filename);
        } else {
            $this->spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        }
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

    public function fillRow($fields)
    {
        $i = 0;
        foreach ($fields as $field) {
            $headertext = $field->title;
            do {
                $i++;
                $header = $this->activeSheet->getCellByColumnAndRow($i, 1);
                if ($header == '') {
                    $header = $headertext;
                    $this->activeSheet->setCellValueByColumnAndRow($i, 1, $headertext);
                }
            } while ($header != $headertext);
            $value = $_POST[$field->name];
            if (is_array($value)) $value = implode(',', $value);
            $this->activeSheet->setCellValueByColumnAndRow($i, $this->currentRow, $value);
        }
    }

    public function saveSpreadSheet()
    {
        $writer = new Xlsx($this->spreadsheet);
        $writer->save($this->filename);
    }
}