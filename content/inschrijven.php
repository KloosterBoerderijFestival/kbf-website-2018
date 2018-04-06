<?php

setlocale(LC_TIME, 'nl_NL');

require_once('ExcelWriter.php');
require_once('InsForm.php');

$form = new InsForm();
$persInf = new InsFieldSet();
$persInf->setTitle("Persoonlijke informatie");

$defaultSize = '50';

$persInf->addField(new InsField('Voornaam', 'fname', true, $defaultSize));
$persInf->addField(new InsField('Achternaam', 'lname', true, $defaultSize));
$persInf->addField(new InsField('Email', 'email', true, $defaultSize));
$form->addFieldset($persInf);

$nogMeer = new InsFieldSet();
$nogMeer->setTitle("Wat we nog meer van je willen weten");
$nogMeer->addField(new InsYesNoField('Wil je graag blijven kamperen?', 'kamperen', true, $defaultSize));
$nogMeer->addField(new InsField('Heb je dieetwensen?', 'dieetwensen', false, $defaultSize));

$nogMeer->addField(new InsField('Wat is je telefoonnummer?', 'telnr', true, $defaultSize));
$nogMeer->addField(new InsField('Welke muziekinstrumenten ben je van plan mee te nemen?', 'muziekinstrumenten', false, $defaultSize));
$nogMeer->addField(new InsField('Zou je zelf een workshop(je) willen geven, en zo ja, waarover?', 'workshopje', false, $defaultSize));
$nogMeer->addField(new InsDateSelectField('Welke dagen kom je naar het KloosterBoerderijFestival?', 'welkedagen', false, '2018-08-11', '2018-08-18'));
$nogMeer->addField(new InsField('Hoe oud ben je?', 'leeftijd', true, $defaultSize));
$nogMeer->addField(new InsField('Wat zoek je of verwacht je op het KloosterBoerderijFestival?', 'verwachtingen', true, $defaultSize));
$nogMeer->addField(new InsField('Waar denk je aan als je aan een boerderij denkt?', 'denkaanboerderij', false, $defaultSize));
$nogMeer->addField(new InsField('Wat is je favoriete eten?', 'favorieteeten', false, $defaultSize));
$nogMeer->addField(new InsField('Waar kom je vandaan?', 'waarvandaan', false, $defaultSize));
$nogMeer->addField(new InsField('Heb je verder nog vragen?', 'verderevragen', false, $defaultSize));
$nogMeer->addField(new InsField('Hoeveel is 5 + 5', 'sommetje', false, $defaultSize));

$form->addFieldset($nogMeer);

$form->display();

$GLOBALS['fieldinfo'] = array();

if (false) echo '1';
else {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        die('Het lijkt erop dat je geen geldig e-mailadres hebt ingevuld (' . $_POST['email'] . '). Kun je het nog eens proberen?');
    }
    echo '<pre>hai';

    try {
        $excelWriter = new ExcelWriter("opslag/inschrijvingen.xlsx");
        $excelWriter->fillRow($form->getAllFields());
        $excelWriter->saveSpreadSheet();
    } catch (Exception $e) {
        die('<font color="red"><b>Er is iets mis gegaan met je inschrijving! Something went wrong!</b></font>');
    }
    echo 'hoi';


    /*
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        $writer->save('data/hello world.xlsx');
    */
    /*
    $f = file('db.csv');
    $preheader = explode(';',$f[0]);
    $header = array();
    for($i = 0; $i < sizeof($preheader); $i++) {
        $header[$preheader[$i]] = $i;
    }
    $output = array();
    $overig = '';
    foreach($_POST as $key => $value) {
        $value = str_replace(';',':,',$value);
        if(is_array($value))
            $value = implode(',',$value);
        $value = str_replace("\r"," ",$value);
        $value = str_replace("\n"," ",$value);
        $value = str_replace('"',"'",$value);
        $value = addslashes($value);
        if(array_key_exists($key,$header)) {
            $output[$header[$key]] = $value;
        }
        else {
            //echo '$overig .= '.$value."\n";
            $overig .= $value . ',';
        }
    }
    $fh = fopen('db.csv','a+');
    for($i = 0; $i < sizeof($output); $i++) {
        fwrite($fh,$output[$i].';');
    }
    fwrite($fh,$overig);
    fwrite($fh,"\r\n");
    fclose($fh);
    //var_dump($output);
*/
    ?>
    Bedankt voor je inschrijving! Hij is binnen. :)
    <?php
}
?>
