<?php
/*
 * Definition of CountryList Datatype
 * 
 * Store a country code
 * Display a countryList (see perstistent object eZCountryInfo) with stored country code as selected country
 * Display list in current language
 */

include_once "extension/ca_countrylist/classes/ezcountryinfo.php";

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
  }
  
  /*!
   Initializes the class attribute with some data.
   \note Default implementation does nothing.
  */
  function initializeClassAttribute( $classAttribute )
  {
    eZCountryInfo::updateCountryList();
  }

  /*
   * Return the content of the attribute
   */
  function objectAttributeContent( $objectAttribute )
  {
    $country_code = $objectAttribute->attribute('data_text');
    
    $result = '';
    if ( $country_code != '' )
    {
      // Fetch country info
      $currentCountry = eZCountryInfo::fetchFromCountryCode( $country_code );
      
      // Fetch country translation
      $result = eZCountryTranslation::fetchFromLanguageCode( $currentCountry->attribute('country_code') );
    }
    
    return $result;
  }

  /*
   * Return the title of the attribute : usefull for object name
   */
  function title( $objectAttribute, $name = null )
  {
    $country_code = $objectAttribute->attribute('data_text');
    
    $result = '';
    if ( $country_code != '' )
    {
      // Fetch country info
      $currentCountry = eZCountryInfo::fetchFromCountryCode( $country_code );
      
      // Fetch country translation
      $result = eZCountryTranslation::fetchFromLanguageCode( $currentCountry->attribute('country_code') );
    }
  }

  function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
  {
    $selectedCountryHTTPName = 'countrylist_' . $contentObjectAttribute->attribute( 'id' );
    if( $http->hasPostVariable( $selectedCountryHTTPName ) )
    {
      $contentObjectAttribute->setAttribute( 'data_text', $http->postVariable( $selectedCountryHTTPName ) );
      $contentObjectAttribute->store();
      return true;
    }
    return false;
  }
  
   /*!
   Fetches the http post variables for collected information
  */
  function fetchCollectionAttributeHTTPInput( $collection, $collectionAttribute, $http, $base, $contentObjectAttribute )
  {
    $selectedCountryHTTPName = 'countrylist_' . $contentObjectAttribute->attribute( 'id' );
    if( $http->hasPostVariable( $selectedCountryHTTPName ) )
    {
      $collectionAttribute->setAttribute( 'data_text', $http->postVariable( $selectedCountryHTTPName ) );
      $collectionAttribute->store();
      return true;
    }
    return false;
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
    $country_code = $objectAttribute->attribute('data_text');
    
    $result = '';
    if ( $country_code != '' )
    {
      // Fetch country info
      $currentCountry = eZCountryInfo::fetchFromCountryCode( $country_code );
      
      // Fetch country translation
      $result = eZCountryTranslation::fetchFromLanguageCode( $currentCountry->attribute('country_code') );
    }
  }
  
  /*!
   \return true if the datatype can be used as an information collector
  */
  function isInformationCollector()
  {
      return true;
  }


}

eZDataType::register( countryList::DATA_TYPE_STRING, 'countryList' );
?>