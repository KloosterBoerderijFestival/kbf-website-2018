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
    private $spreadsheet;
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
        foreach ($fields as $headertext => $value) {
            $col = $this->getColumn($headertext);
            $this->activeSheet->setCellValueByColumnAndRow($col, $this->currentRow, $value);
        }
    }

    public function saveSpreadSheet()
    {
        $writer = new Xlsx($this->spreadsheet);
        $writer->save($this->filename);
    }

    public function hasDuplicates($fieldname, $fields)
    {
        if($this->currentRow > 2) { // row > 2 means we have an inschrijving
            $col = $this->getColumn($fieldname);
            for ($row = 0; $row < $this->currentRow; $row++) {
                $rowvalue = $this->activeSheet->getCellByColumnAndRow($col, $row)->getValue();
                if($rowvalue == $fields[$fieldname]) {
                    return true;
                }
            }
        }
        return false;
    }

    private function getColumn($headertext)
    {
        $i = 0;
        do {
            $i++;
            $header = $this->activeSheet->getCellByColumnAndRow($i, 1);
            if ($header == '') {
                $header = $headertext;
                $this->activeSheet->setCellValueByColumnAndRow($i, 1, $headertext);
            }
        } while ($header != $headertext);
        return $i;
    }
}