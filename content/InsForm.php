<?php

class InsForm {
    var $fieldsets = array();

    function addFieldset($fieldset) {
        $this->fieldsets[] = $fieldset;
    }

    function display() {
        foreach($this->fieldsets as $fieldset) {
            $fieldset->display();
        }
    }

    function getAllFields() {
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

    function addField($field) {
        $this->fields[] = $field;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    function display() {

        echo "<fieldset><h4>" . $this->title . "</h4>\r\n";
        echo "<table border='0'>\r\n";

        foreach($this->fields as $field) {
            $field->display();
        }

        echo "</table></fieldset>\r\n";
    }
}

class InsField
{
    var $title;
    var $name;
    var $required;

    function __construct($title, $name, $required) {
        $this->title = $title;
        $this->name = $name;
        $this->required = $required;
    }

    function display() {
        $in = '';
        if ($this->required) {
            $in = '<em>*</em>';
        }
        echo '<tr><td><label for="' . $this->name . '">' . $this->title . $in . ':</label></td><td><input type="text" name="' . $this->name . '" value=""/></td></tr>';
    }

}

