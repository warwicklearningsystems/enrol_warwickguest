<?php
namespace enrol_warwickguest\selector\type\settings;

use \enrol_warwickguest\selector\type\settings\designation;

class potential_designation extends designation{
    
    
    public function __construct($name, $options) {
        parent::__construct($name, $options);
    }

    /**
     * 
     * @global type $DB
     * @param string $search
     * @return type
     */
    public function find_users($search) {
        global $DB;
        $existingDesignations = $this->config->getFlatConfigByProperty( null, true );
        
        list($wherecondition, $params) = $this->search_sql($search, 'u');

        $sql = "SELECT distinct($this->propertyFromConfigToDisplay) FROM {user} u WHERE {$this->propertyFromConfigToDisplay} is not null AND {$this->propertyFromConfigToDisplay} not like \"\"";        

        if( $existingDesignations )
            $sql.=" AND $this->propertyFromConfigToDisplay not in (".implode(",",$existingDesignations).")";

        if($search)
            $sql.= " AND ".$wherecondition;
        
        $designations = $DB->get_records_sql( $sql, $params );
        
        $results = array(); // The results array we are building up.
        foreach ($designations as $key=>$designation) {
        
            $group = $this->getGroupName( $designation );
            $designation->id = $designation->{$this->propertyFromConfigToDisplay};
            $results[ $group ][] = $designation ;
        }

        return $results;
    }

    protected function get_options() {
        global $CFG;
        $options = parent::get_options();

        $options['file'] = 'enrol/warwickguest/classes/selector/type/settings/potential_designation.php';
        $options['contextid'] = $this->context->id;
        $options['plugin'] =  $this->plugin;
        return $options;
    }
}

