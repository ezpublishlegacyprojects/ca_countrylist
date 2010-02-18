{def $locale = ezini('RegionalSettings','Locale','site.ini')}
{def $localeArray = $locale|explode('-')}
{def $countryList = fetch_country_list( hash('countryCode',$localeArray[1]|upcase) )}

<ul>
{foreach $countryList as $country}
    <li>{$country.translation}</li>
{/foreach}
</ul>


Should Display country store in datatype