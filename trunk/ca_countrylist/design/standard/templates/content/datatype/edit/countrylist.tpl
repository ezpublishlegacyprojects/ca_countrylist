{def $locale = ezini('RegionalSettings','Locale','site.ini')}
{def $localeArray = $locale|explode('-')}
{def $countryList = fetch_country_list( hash('countryCode',$localeArray[1]|upcase) )}
{if $attribute.data_text|eq('')}
    {def $matchItem = $localeArray[1]|upcase}
{else}
    {def $matchItem = $attribute.data_text}
{/if}

<select name="countrylist_{$attribute.id}" id="countrylist_{$attribute.id}">
{foreach $countryList as $country}
    <option value="{$country.country_code}" {if $matchItem|eq($country.country_code)}selected="selected"{/if}>{$country.translation}</option>
{/foreach}
</select>