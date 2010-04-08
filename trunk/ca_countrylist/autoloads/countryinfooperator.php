<?php

/*!
  \class   CountryInfoOperator countryinfooperator.php
  \ingroup eZTemplateOperators
  \brief   Handles template operator countryinfo.
  \version 1.0
  \date    Thursday 18 February 2010 3:16:50 pm
  \author  Matthieu Sévère

*/


class CountryInfoOperator
{
    /*!
      Constructor, does nothing by default.
    */
    function CountryInfoOperator()
    {
    }

    /*!
     \return an array with the template operator name.
    */
    function operatorList()
    {
        return array( 'fetch_country_list' );
    }

    /*!
     \return true to tell the template engine that the parameter list exists per operator type,
             this is needed for operator classes that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }

    /*!
     See eZTemplateOperator::namedParameterList
    */
    function namedParameterList()
    {
        return array( 'fetch_country_list' => array( 'params' => array( 'type' => 'string',
                                                                      'required' => false,
                                                                      'default' => '' ) ) );
    }


    /*!
     Executes the PHP function for the operator cleanup and modifies \a $operatorValue.
    */
    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters, $placement )
    {
        $params = $namedParameters['params'];
        
        switch ( $operatorName )
        {
            case 'fetch_country_list':
            {
                $operatorValue = $this->fetchCountryList( $params );
            } break;
        }
    }
    
    function fetchCountryList( $params )
    {
      // Fetch country of current locale
      $currentCountry = eZCountryInfo::fetchFromCountryCode( $params['countryCode'] );
      
      // Fetch translation of country list in current locale (if there is one)
      $currentLanguages = $currentCountry->attribute('languages');
      
      $translatedList = eZCountryTranslation::fetchListFromLanguageCode( substr($currentLanguages, 0, 2) );
      
      return $translatedList;
    }
}

?>
