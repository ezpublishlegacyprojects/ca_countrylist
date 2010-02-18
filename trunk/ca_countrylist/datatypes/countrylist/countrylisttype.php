<?php
/*
 * Definition of CountryList Datatype
 * 
 * Store a country code
 * Display a countryList (see perstistent object eZCountryInfo) with stored country code as selected country
 * Display list in current language
 */


class countryList extends eZDataType
{
  const DATA_TYPE_STRING = "countrylist";

  /*!
   Construction of the class, note that the second parameter in eZDataType
   is the actual name showed in the datatype dropdown list.
   */
  function __construct()
  {
    parent::__construct( self::DATA_TYPE_STRING, ezi18n( 'extension/ca_countrylist/datatype', 'Country List', 'Datatype name'),
    array( 'serialize_supported' => true) );
  }

  function storeObjectAttribute( $contentObjectAttribute )
  {
    return true;
  }

  /*!
   Performs necessary actions with attribute data after object is published,
   it means that you have access to published nodes.
   \return True if the value was stored correctly.
   \note The method is entirely up to the datatype, for instance
         it could reuse the available types in the the attribute or
         store in a separate object.
  
   \note Might be transaction unsafe.
  */
  function onPublish( $contentObjectAttribute, $contentObject, $publishedNodes )
  {
    eZCountryInfo::updateCountryList();
  }

  /*
   * Return the content of the attribute
   */
  function objectAttributeContent( $objectAttribute )
  {

  }

  /*
   * Return the title of the attribute : usefull for object name
   */
  function title( $objectAttribute, $name = null )
  {

  }

  function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
  {

  }

  function isIndexable()
  {
    return true;
  }


  function sortKeyType()
  {
    return '';
  }

  function deleteStoredObjectAttribute( $contentObjectAttribute, $version = null )
  {

  }

  /*
   * Retrieve data from submitted edit form
   */
  function customObjectAttributeHTTPAction( $http, $action, $contentObjectAttribute, $parameters )
  {
    switch ( $action )
    {
      case "custom_action" :
        {
          // execute action
        }break;
      default :
        {
          eZDebug::writeError( "Unknown custom HTTP action: " . $action, "eZOptionType" );
        }break;
    }
  }

  function toString( $objectAttribute )
  {
  }


}

eZDataType::register( countryList::DATA_TYPE_STRING, 'countryList' );
?>