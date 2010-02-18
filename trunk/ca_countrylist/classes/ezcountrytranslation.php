<?php

/**
 * ezcountrytranslation persistent object class definition
 * 
 */

include_once "extension/ca_countrylist/classes/wscountryinfo.php";
include_once "extension/ca_countrylist/classes/ezcountryinfo.php";

class eZCountryTranslation extends eZPersistentObject
{
    /**
     * Construct, use {@link eZCountryTranslation::create()} to create new objects.
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
                                                'language_code' => array( 'name' => 'languageCode',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ),
                                                'translation' => array( 'name' => 'translation',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true )
                                               ),
                             'keys' => array( 'id' ),
                             'function_attributes' => array(),
                             'increment_key' => 'id',
                             'class_name' => 'eZCountryTranslation',
                             'name' => 'ezcountrytranslation' );
        return $def;
    }
    
    /**
     * Creates new eZCountryTranslation object
     * 
     * @static
     * @param array $row
     * @return eZCountryTranslation
     */
    public static function create( $row = array() )
    {
        $object = new self( $row );
        return $object;
    }

    /**
     * Fetch eZCountryTranslation by given id.
     * 
     * @param int $id
     * @return null|eZCountryTranslation
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
    
    static function addTranslation( $languageCode )
    {
        $countryList = wsCountryInfo::getCountryList( $languageCode );
       
        foreach( $countryList as $country )
        {
          $countryTranslationObject = eZCountryTranslation::create();
          $countryTranslationObject->setAttribute('country_code',$country->countryCode);
          $countryTranslationObject->setAttribute('language_code',$languageCode);
          $countryTranslationObject->setAttribute('translation',$country->countryName);
          $countryTranslationObject->store();
        }
    }

    static function compare( $a, $b )
    {
      $al = self::normalize(strtolower($a->attribute('translation')));
      $bl = self::normalize(strtolower($b->attribute('translation')));

      return strcasecmp($al,$bl);
    }
    
    static function normalize ($string) {
        $table = array(
            'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
            'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
        );
        
        return strtr($string, $table);
    }
}

?>