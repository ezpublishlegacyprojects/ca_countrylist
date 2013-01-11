{def $locale = ezini( 'RegionalSettings', 'Locale', 'site.ini' )}

{def $localeArray = $locale|explode( '-' )}
{def $language = ezini( 'HTTP', 'ContentLanguage', concat( $locale, '.ini' ), 'share/locale', true() )|explode( '-' ).0|downcase}
{if ne( $language|count_chars(), 2)}
    {set $language = ''}
{/if}
{def $countryList = fetch_country_list( hash( 'countryCode', $localeArray[1]|upcase,
                                              'languageCode', $language ) )}
{if $attribute.data_text}
    {def $matchItem = $attribute.data_text}
{else}
    {def $matchItem = $localeArray[1]|upcase}
{/if}

{if and( ezini( 'RegionalSettings', 'CountrylistInit', 'site.ini' ), ezini( 'RegionalSettings', 'CountrylistInit', 'site.ini' )|count_chars()|gt( 0 ) )}
	{set $matchItem =  ezini( 'RegionalSettings', 'CountrylistInit', 'site.ini' )|upcase}
{/if}

<select name="countrylist_{$attribute.id}" id="countrylist_{$attribute.id}">
    <option value=""></option>
{foreach $countryList as $country}
    <option value="{$country.country_code}" {if $matchItem|eq($country.country_code)}selected="selected"{/if}>{$country.translation}</option>
{/foreach}
</select>