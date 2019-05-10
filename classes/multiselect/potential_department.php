<?php
namespace enrol_warwickguest\multiselect;

use \local_enrolmultiselect\type\available\potential_department as availablepotentialdepartment;

class potential_department extends availablepotentialdepartment{

    protected $field = 'customtext2';

    /**
     * 
     * @param type $name
     * @param type $options
     */
    public function __construct($name, $options) {
        parent::__construct($name, $options);
    }
}