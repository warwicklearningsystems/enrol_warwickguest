<?php
namespace enrol_warwickguest\selector\type\user;

use \enrol_warwickguest\selector\type\settings\designation;
use \enrol_warwickguest\selector\search;
use \enrol_warwickguest\selector\type\traits\user;

class potential_designation extends designation{
    use user;
    
    protected $enrolInstance;
    
    public function __construct($name, $options) {
        
        $this->enrolInstance = $options['enrol_instance'];
        parent::__construct($name, $options);
    }

    protected function get_options() {
        global $CFG;
        $options = parent::get_options();

        $options['file'] = 'enrol/warwickguest/classes/selector/type/user/potential_designation.php';
        $options['plugin'] =  $this->plugin;
        $options['enrol_instance'] = $this->enrolInstance;
        return $options;
    }
    
    /**
     * 
     * @global type $DB
     * @param string $search
     * @return type
     */
    public function find_users($search) {
        global $DB;
        
        $searchObject = new search( $search, $this->propertyFromConfigToDisplay, $this->searchanywhere );
        $results = $this->filterStoredValues( parent::find_users( $search ), $searchObject, 'customtext1');

        return $results;
    }
}