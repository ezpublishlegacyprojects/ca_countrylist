<?php

/**
 * ezcountryinfo persistent object class definition
 * 
 */
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
                                                'country_code' => array( 'name' => 'CountryCode',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ),
                                                'languages' => array( 'name' => 'Languages',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ),
                                                'continent' => array( 'name' => 'Continent',
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
      
    }
    
}

?>