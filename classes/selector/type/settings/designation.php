<?php
namespace enrol_warwickguest\selector\type\settings;

use \enrol_warwickguest\selector\base;
use \enrol_warwickguest\selector\config;
use \enrol_warwickguest\selector\utils;
use \enrol_warwickguest\selector\search;

class designation extends base{
    
    const DEFAULT_GROUP = 'Other';
    
    const GROUPS = ['User', 'Academic', 'Partner', 'Staff'];
    
    /**
     *
     * @var string 
     */
    protected $propertyFromConfigToDisplay = 'phone2';

    /**
     *
     * @var config 
     */
    protected $config;
    
    /**
     *
     * @var string 
     */
    protected $configName = 'designations';
    
    /**
     * 
     * @global type $CFG
     * @param string $name
     * @param array $options
     */
    public function __construct($name, $options) {
        global $CFG;
        
        require_once($CFG->dirroot . '/lib/accesslib.php');
        
        $this->config = new config( $options['plugin'], $this->configName, $this->propertyFromConfigToDisplay );
        
        parent::__construct($name, $options);
        require_once($CFG->dirroot . '/group/lib.php');
    }

    protected function get_options() {
        global $CFG;
        $options = parent::get_options();

        $options['file'] = 'enrol/warwickguest/classes/selector/type/settings/designation.php';
        $options['plugin'] =  $this->plugin;
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

        if( !$search ){
            $designationObjectMap = $this->config->getConfig();

            // No designations at all.
            if(!$designationObjectMap)
                return array();
        }else{
            $searchObject = new search( $search, $this->propertyFromConfigToDisplay, $this->searchanywhere );
            $designationObjectMap = $this->config->getConfig( $searchObject );
        }

        $results = array(); // The results array we are building up.

        foreach ( $designationObjectMap as $key => $designationObject ) {
            $group = $this->getGroupName( $designationObject );
            $results[ $group ][] = $designationObject;
        }

        return $results;
    }
    
    public function getGroups() {
        return self::GROUPS;
    }
    
    public function getDefaultGroup() {
        return self::DEFAULT_GROUP;
    }
}