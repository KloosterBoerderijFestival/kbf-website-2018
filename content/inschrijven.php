<?php

$template = file_get_contents('inschrijfdummy.tmpl');
list($header, $footer) = explode('<p>PLEKJEVASTHOUDER</p>', $template);

echo $header;

//echo file_get_contents('phpincludes/header.inc');
//echo "<div class=\"container\"><div class='row'><div class=\"col-md-12\"><p>";
//echo "<h1>DEZE TEKST VALT WEG ONDER DE HEADER EN IK HEB GEEN FLAUW BENUL WAAROM</h1>";

const ARBITRARY_CONSTANT_HIGH_ENOUGH_TO_ENSURE_PROPER_INPUT = 3;

require_once('ExcelWriter.php');
require_once('TextWriter.php');
require_once('InsForm.php');

$form = new InsForm();
$persInf = new InsFieldSet();
$persInf->setTitle("Persoonlijke informatie");

$defaultSize = '30';

$persInf->addField(new InsField('Voornaam', 'fname', true, $defaultSize));
$persInf->addField(new InsField('Achternaam', 'lname', true, $defaultSize));
$persInf->addField(new InsEmailField('Email', 'email', true, $defaultSize));
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
$nogMeer->addField(new InsCaptchaField('Hoeveel is drie maal drie (mag ook als Pippi Langkous)', 'sommetje', false, $defaultSize));

$form->addFieldset($nogMeer);

if (count($_POST) > ARBITRARY_CONSTANT_HIGH_ENOUGH_TO_ENSURE_PROPER_INPUT) {
    $errors = $form->validate();
    if ($errors == "") {
        try {
            $textWriter = new TextWriter("opslag/");
            $textWriter->fillRow($form->getAllFields(), $_POST['fname'] . ' ' . $_POST['lname']);

            $excelWriter = new ExcelWriter("opslag/inschrijvingen.xlsx");
            $excelWriter->fillRow($form->getAllFields());
            $excelWriter->saveSpreadSheet();
        } catch (Exception $e) {
            die('<span style="color: red; "><b>Er is iets mis gegaan met je inschrijving! Something went wrong!</b></span>');
        }
        ?>
        <b>Bedankt voor je inschrijving! Hij is binnen. :)</b><b/>
        (TODO: alle waarden tonen)
        <?php
    } else {
        echo "<span style=\"color: red; \">Niet alle velden zijn goed ingevuld:<br />\r\n";
        echo $errors;
        echo "</span><br /><br />\r\n";
        $form->display();
//        echo "<pre>";var_dump($_POST);echo "</pre>";
    }
} else {
    $form->display();
}
//echo file_get_contents('phpincludes/footer.inc');
echo $footer;
?>
