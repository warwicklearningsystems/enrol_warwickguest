<?php
namespace enrol_warwickguest\selector\type\user;

use \enrol_warwickguest\selector\base;
use \enrol_warwickguest\selector\config;
use \enrol_warwickguest\selector\utils;
use \enrol_warwickguest\selector\search;
use \enrol_warwickguest\selector\type\traits\user;

class designation extends base{
    
    use user;
    
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
     * @var type 
     */
    protected $enrolInstance;


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
        $this->enrolInstance = $options['enrol_instance'];
        parent::__construct($name, $options);
        require_once($CFG->dirroot . '/group/lib.php');
    }

    protected function get_options() {
        global $CFG;
        $options = parent::get_options();

        $options['file'] = 'enrol/warwickguest/classes/selector/type/settings/designation.php';
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
        
        $existingDesignations = $this->config->getFlatConfigByProperty( null, true );
        
        list($wherecondition, $params) = $this->search_sql($search, 'u');

        
        $searchObject = new search( $search , $this->propertyFromConfigToDisplay, $this->searchanywhere );
        $designations = self::extractFlatConfig( $this->enrolInstance, $search ? $searchObject : null);
        
        if(!$designations)
            return array();
        
        $results = array(); // The results array we are building up.
        foreach ($designations as $key=>$designation) {
        
            $group = $this->getGroupName( $designation );
            $designation->id = $designation->{$this->propertyFromConfigToDisplay};
            $results[ $group ][] = $designation ;
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