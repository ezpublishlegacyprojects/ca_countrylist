<?php

/**
 * ezcountryinfo persistent object class definition
 * 
 */

include_once "extension/ca_countrylist/classes/wscountryinfo.php";
include_once "extension/ca_countrylist/classes/ezcountrytranslation.php";

class eZCountryInfo extends eZPersistentObject
{
    /**
     * Construct, use {@link eZCountryInfo::create()} to create new objects.
     * 
     * @param array $row
     */
    public function __construct( $row )
    {
        parent::__construct( $row );
    }

    /**
     * Fields definition.
     * 
     * @static
     * @return array
     */
    public static function definition()
    {
        static $def = array( 'fields' => array( 'id' => array( 'name' => 'ID',
                                                               'datatype' => 'integer',
                                                               'default' => 0,
                                                               'required' => true ),
                                                'country_code' => array( 'name' => 'countryCode',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ),
                                                'languages' => array( 'name' => 'languages',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ),
                                                'continent' => array( 'name' => 'continent',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true )
                                               ),
                             'keys' => array( 'id' ),
                             'function_attributes' => array(),
                             'increment_key' => 'id',
                             'class_name' => 'eZCountryInfo',
                             'name' => 'ezcountryinfo' );
        return $def;
    }
    
    /**
     * Creates new eZCountryInfo object
     * 
     * @static
     * @param array $row
     * @return eZCountryInfo
     */
    public static function create( $row = array() )
    {
        $object = new self( $row );
        return $object;
    }

    /**
     * Fetch countryInfo by given id.
     * 
     * @param int $id
     * @return null|ezcomComment
     */
    static function fetch( $id )
    {
        $cond = array( 'id' => $id );
        $return = eZPersistentObject::fetchObject( self::definition(), null, $cond );
        return $return;
    }
    
    static function updateFields( $fields, $conditions )
    {
        $parameters = array();
        $parameters['definition'] = self::definition();
        $parameters['update_fields'] = $fields;
        $parameters['conditions'] = $conditions;
        //use try to catch the error
        eZPersistentObject::updateObjectList( $parameters );
    }

    public function remove( $conditions = null, $extraConditions = null )
    {
        parent::remove( $conditions, $extraConditions );
    }
    
    static function updateCountryList ()
    {
      $countryList = wsCountryInfo::getCountryList();
      
      foreach( $countryList as $country )
      {
        // check if the country is already in DB
        $def = eZCountryInfo::definition();
        $conds = array( 'country_code' => $country->countryCode );
        $existingCountry = eZPersistentObject::fetchObjectList($def, null, $conds);

        if ( count($existingCountry) == 0 )
        {
          // add a record
          $countryObject = eZCountryInfo::create();
          $countryObject->setAttribute('country_code',$country->countryCode);
          $countryObject->setAttribute('languages',$country->languages);
          $countryObject->setAttribute('continent',$country->continent);
          $countryObject->store();
          
          //add english translation
          $countryTranslationObject = eZCountryTranslation::create();
          $countryTranslationObject->setAttribute('country_code',$country->countryCode);
          $countryTranslationObject->setAttribute('language_code','en');
          $countryTranslationObject->setAttribute('translation',$country->countryName);
          $countryTranslationObject->store();
        }
        else
        {
          // update record
          $countryObject = $existingCountry[0];
          $countryObject->setAttribute('country_code',$country->countryCode);
          $countryObject->setAttribute('languages',$country->languages);
          $countryObject->setAttribute('continent',$country->continent);
          $countryObject->store();
        }
      }
    }
    
    public static function fetchFromCountryCode( $countryCode )
    {
        $def = eZCountryInfo::definition();
        $conds = array( 'country_code' => $countryCode );
        $currentCountry = eZPersistentObject::fetchObject($def, null, $conds);
        
        if ( !is_object($currentCountry) )
        {
          eZCountryInfo::updateCountryList();
          $currentCountry = eZPersistentObject::fetchObject($def, null, $conds);
        }
        
        if ( is_object($currentCountry) )
        {
            return $currentCountry;
        }
        else
        {
            return false;
        }
    }
    
}

?>