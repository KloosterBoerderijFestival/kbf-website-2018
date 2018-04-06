<?php

class InsForm
{
    var $fieldsets = array();

    function addFieldset($fieldset)
    {
        $this->fieldsets[] = $fieldset;
    }

    function display()
    {
        echo '<form method="post">';
        foreach ($this->fieldsets as $fieldset) {
            $fieldset->display();
        }

        echo '<input type="Submit"></form>';
    }

    function getAllFields()
    {
        $fields = array();
        foreach ($this->fieldsets as $fieldset) {
            $fields = array_merge($fields, $fieldset->fields);
        }
        return $fields;
    }
}

class InsFieldSet
{
    var $fields = array();
    var $title;

    function addField($field)
    {
        $this->fields[] = $field;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    function display()
    {

        echo "<fieldset><h4>" . $this->title . "</h4>\r\n";
        echo "<table border='0'>\r\n";

        foreach ($this->fields as $field) {
            $field->display();
        }

        echo "</table></fieldset>\r\n";
    }
}

class InsField
{
    var $required;
    var $name;
    var $title;
    var $size;

    function __construct($title, $name, $required, $size)
    {
        $this->size = $size;
        $this->title = $title;
        $this->name = $name;
        $this->required = $required;
    }

    function display()
    {
        $in = '';
        if ($this->required) {
            $in = '<em>*</em>';
        }
        echo '<tr><td><label for="' . $this->name . '">' . $this->title . $in . ':</label></td><td> ' . $this->getFormField() . '</td></tr>' . "\r\n";
    }

    function getFormField()
    {
        return '<input type="text" name="' . $this->name . '" value="" size="' . $this->size .'"/>';
    }

}

class InsYesNoField extends InsField
{

    function getFormField()
    {
        return '<select name="' . $this->name . '"><option value="">Selecteer &eacute;&eacute;n</option><option value="Ja"> Ja</option><option value="Nee"> Nee</option></select>';
    }
}

class InsDateSelectField extends InsField
{
    var $startDate;
    var $endDate;
    var $dates = array();

    const SHORTWEEKDAYS = array('zo', 'ma', 'di', 'wo', 'do', 'vr', 'za');

    function __construct($title, $name, $required, $startDate, $endDate)
    {
        parent::__construct($title, $name, $required, '100');
        $this->getDateArray($startDate, $endDate);
    }

    function getDateArray($startDate, $endDate)
    {
        $this->dates[] = strtotime($startDate);
        $i = 1;
        do {
            $nextDate = strtotime($startDate . '+' . $i . ' days');
            $this->dates[] = $nextDate;
            $i++;
        } while ($nextDate < strtotime($endDate));
    }

    function getFormField()
    {
        $ret = '';
        $ret .= '<ul>';
        $ret .= $this->getCheckItem('De volledige week', 'De volledige week');
        foreach ($this->dates as $date) {
            $ret .= $this->getCheckItem(self::SHORTWEEKDAYS[intval(strftime('%w', $date))] . trim(strftime('%e', $date)), self::SHORTWEEKDAYS[intval(strftime('%w', $date))] . strftime(' %e augustus', $date));
        }
        $ret .= '</ul>';
        return $ret;
    }

    private function getCheckItem($short, $long)
    {
        $ret2 = '';
        $ret2 .= '<li>';
        $ret2 .= '<input name="' . $this->name . '[]" type="checkbox" value="' . $short . '">';
        $ret2 .= '<span>' . $long . '</span>';
        $ret2 .= '</li>' . "\r\n";
        return $ret2;
    }
}


