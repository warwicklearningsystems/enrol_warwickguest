<?php
namespace enrol_warwickguest\multiselect;

use \local_enrolmultiselect\type\available\department as allowed_department;


class department extends allowed_department{

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