<?php

require_once('ExcelWriter.php');
require_once('InsForm.php');

$form = new InsForm();
$fieldSet = new InsFieldSet();
$fieldSet->setTitle("Persoonlijke informatie");

$fieldSet->addField(new InsField('Voornaam', 'fname', true));
$fieldSet->addField(new InsField('Achternaam', 'lname', true));
$fieldSet->addField(new InsField('Email', 'email', true));

$form->addFieldset($fieldSet);

$form->display();

var_dump($form->getAllFields());

$GLOBALS['fieldinfo'] = array();

function field($title, $name, $required)
{
    $in = '';
    if ($required) {
        $in = '<em>*</em>';
    }
    echo '<tr><td><label for="' . $name . '">' . $title . $in . ':</label></td><td><input type="text" name="' . $name . '" value=""/></td></tr>';
    $GLOBALS['fieldinfo'][$name] = array($title, $required);
}

//if(!isset($_POST) || count($_POST) == 0) {
?>
<h3 class="section-heading">Aanmeldingdetails</h3>
<form method="post">


    <fieldset><h4>Wat we nog meer willen weten</h4>
        <table border="0">
            <tr>
                <td><label for="kamperen" class="ee-reg-page-questions">Wil je graag blijven kamperen?<em>*</em></label>
                </td>
                <td>
                    <select name="kamperen">
                        <option value="">Selecteer &eacute;&eacute;n</option>
                        <option value="Ja"> Ja</option>
                        <option value="Nee"> Nee</option>
                    </select></td>
            </tr>
            <?php field('Heb je dieetwensen?', 'dieetwensen', false); ?>
            <?php field('Wat is je telefoonnummer?', 'telnr', true); ?>
            <?php field('Welke muziekinstrumenten ben je van plan mee te nemen?', 'muziekinstrumenten', false); ?>
            <?php field('Zou je zelf een workshop(je) willen geven, en zo ja, waarover?', 'workshopje', false); ?>
            <label for="MULTIPLE_14" class="ee-reg-page-questions">Welke dagen kom je naar het
                KloosterBoerderijFestival?<em>*</em></label>
            <ul class="options-list-check event_form_field">
                <li>
                    <label for="Devolledigeweek(wo-wo)-4_1" class="ee-reg-page-questions checkbox-lbl">
                        <input id="Devolledigeweek(wo-wo)-4_1" title=""
                               class=" required  ee-reg-page-questions MULTIPLE_14" name="MULTIPLE_14[]" type="checkbox"
                               value="De volledige week (wo-wo)"/>
                        <span>De volledige week (wo-wo)</span>
                    </label>
                </li>
                <li>
                    <label for="woensdag22/7-4_1" class="ee-reg-page-questions checkbox-lbl">
                        <input id="woensdag22/7-4_1" title="" class=" required  ee-reg-page-questions MULTIPLE_14"
                               name="MULTIPLE_14[]" type="checkbox" value="woensdag 22/7"/>
                        <span>woensdag 22/7</span>
                    </label>
                </li>
                <li>
                    <label for="donderdag23/7-4_1" class="ee-reg-page-questions checkbox-lbl">
                        <input id="donderdag23/7-4_1" title="" class=" required  ee-reg-page-questions MULTIPLE_14"
                               name="MULTIPLE_14[]" type="checkbox" value="donderdag 23/7"/>
                        <span>donderdag 23/7</span>
                    </label>
                </li>
                <li>
                    <label for="vrijdag24/7-4_1" class="ee-reg-page-questions checkbox-lbl">
                        <input id="vrijdag24/7-4_1" title="" class=" required  ee-reg-page-questions MULTIPLE_14"
                               name="MULTIPLE_14[]" type="checkbox" value="vrijdag 24/7"/>
                        <span>vrijdag 24/7</span>
                    </label>
                </li>
                <li>
                    <label for="zaterdag25/7-4_1" class="ee-reg-page-questions checkbox-lbl">
                        <input id="zaterdag25/7-4_1" title="" class=" required  ee-reg-page-questions MULTIPLE_14"
                               name="MULTIPLE_14[]" type="checkbox" value="zaterdag 25/7"/>
                        <span>zaterdag 25/7</span>
                    </label>
                </li>
                <li>
                    <label for="zondag26/7-4_1" class="ee-reg-page-questions checkbox-lbl">
                        <input id="zondag26/7-4_1" title="" class=" required  ee-reg-page-questions MULTIPLE_14"
                               name="MULTIPLE_14[]" type="checkbox" value="zondag 26/7"/>
                        <span>zondag 26/7</span>
                    </label>
                </li>
                <li>
                    <label for="maandag27/7-4_1" class="ee-reg-page-questions checkbox-lbl">
                        <input id="maandag27/7-4_1" title="" class=" required  ee-reg-page-questions MULTIPLE_14"
                               name="MULTIPLE_14[]" type="checkbox" value="maandag 27/7"/>
                        <span>maandag 27/7</span>
                    </label>
                </li>
                <li>
                    <label for="dinsdag28/7-4_1" class="ee-reg-page-questions checkbox-lbl">
                        <input id="dinsdag28/7-4_1" title="" class=" required  ee-reg-page-questions MULTIPLE_14"
                               name="MULTIPLE_14[]" type="checkbox" value="dinsdag 28/7"/>
                        <span>dinsdag 28/7</span>
                    </label>
                </li>
                <li>
                    <label for="woensdag29/7-4_1" class="ee-reg-page-questions checkbox-lbl">
                        <input id="woensdag29/7-4_1" title="" class=" required  ee-reg-page-questions MULTIPLE_14"
                               name="MULTIPLE_14[]" type="checkbox" value="woensdag 29/7"/>
                        <span>woensdag 29/7</span>
                    </label>
                </li>
            </ul>
            </div>
            <div class="event_form_field">
                <?php field('Hoe oud ben je?', 'leeftijd', true); ?>
                <?php field('Wat zoek je of verwacht je op het KloosterBoerderijFestival?', 'verwachtingen', true); ?>
                <?php field('Waar denk je aan als je aan een boerderij denkt?', 'denkaanboerderij', false); ?>
                <?php field('Wat is je favoriete eten?', 'favorieteeten', false); ?>
                <?php field('Waar kom je vandaan?', 'waarvandaan', false); ?>
                <?php field('Heb je verder nog vragen?', 'verderevragen', false); ?>
        </table>
        <input type="submit" value="Verzenden"/>
    </fieldset>
</form>
<?php
//}
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
