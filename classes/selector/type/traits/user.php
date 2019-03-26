<?php
namespace enrol_warwickguest\selector\type\traits;

use \enrol_warwickguest\selector\utils;
use \enrol_warwickguest\selector\search;

trait user{

    /**
     * 
     * @param type $enrolInstance
     * @param search $search
     * @param type $field
     * @return boolean
     */
    public static function extractFlatConfig( $enrolInstance, search $search = null, $field = 'customtext1' ){

        if( is_null( $enrolInstance->{$field} ) )
            return false;
        
        $row = $enrolInstance->{$field};

        $configMap = utils::arrayToObject( utils::JsonToArray( $row ) );

        if( $search && $search->getStringToFind() ){
            $configArray = [];
            
            foreach( $configMap as $key=>$config){
                if( $search->getSearchAnyWhere() ){
                    if( !utils::strContains( $search->getStringToFind(), $config->{$search->getField()} ) ){
                        unset( $configMap->$key );
                    }
                }else{
                    if( !utils::strStartsWith( $search->getStringToFind(), $config->{$search->getField()} ) ){
                        unset( $configMap->$key );
                    }
                }
                
            }
        }
        
        return $configMap;
    }

    /**
     * 
     * @param type $availableDesignations
     * @param search $search
     * @param type $field
     * @return boolean
     */
    protected function filterStoredValues( $availableDesignations, search $search = null, $field ){

        $storedDesignations = self::extractFlatConfig( $this->enrolInstance, $search, $field );
        
        if( !$storedDesignations )
            return false;
        
        foreach( $storedDesignations as $storedDesignationkey => $storedDesignationObject ){
            foreach( $availableDesignations as $avilableDesignationGroupName => $avilableDesignationGroupMap ){
        
                foreach( $avilableDesignationGroupMap as $avilableDesignationKey => $avilableDesignationObject ){
                
                    $availableDesignation = $avilableDesignationObject->{$this->propertyFromConfigToDisplay};
                    $storedDesignation = $storedDesignationObject->{$this->propertyFromConfigToDisplay};
                    
                    if( $availableDesignation == $storedDesignation ){
                        unset($availableDesignations[ $avilableDesignationGroupName ] [$avilableDesignationKey ]);
                        
                        if( !count($availableDesignations[ $avilableDesignationGroupName ] ) ){ //if there are not more items left in this group, remove the group
                            unset( $availableDesignations[ $avilableDesignationGroupName ] );
                        }
                            
                    }
                }
            }
        }
        
        return $availableDesignations;
    }
    
    /**
     * 
     * @param type $instance
     * @param type $search
     * @param type $field
     * @param type $property
     * @return boolean
     */
    public static function hasValue( $instance, $search, $field, $property ){
        

        $storedValues = self::extractFlatConfig( $instance, null, $field );
        
        if( !$storedValues )
            return false;
        
        foreach( $storedValues as $storedValuekey => $storedValueObject ){
            if( $search == $storedValueObject->{$property}){
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * 
     */
    public static function isValueSet( $instance, $field ){
        if( is_null($instance->{$field}) )
            return false;
            
        return count( utils::JsonToArray( $instance->{$field} ) ) ? true : false;
    }
}