{def $locale = ezini('RegionalSettings','Locale','site.ini')}
{def $localeArray = $locale|explode('-')}
{def $countryList = fetch_country_list( hash('countryCode',$localeArray[1]|upcase) )}

<select name="{$attribute_base}_countrylist_{$attribute.id}">
{foreach $countryList as $country}
    <option value="{$country.country_code}">{$country.translation}</option>
{/foreach}
</select>