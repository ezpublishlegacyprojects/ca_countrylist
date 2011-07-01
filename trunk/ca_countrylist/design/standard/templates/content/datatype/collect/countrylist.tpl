{def $locale = ezini( 'RegionalSettings', 'Locale', 'site.ini' )}
{def $localeArray = $locale|explode( '-' )}
{def $language = ezini( 'HTTP', 'ContentLanguage', concat( $locale, '.ini' ), 'share/locale', true() )|explode( '-' ).0|downcase}
{if ne( $language|count_chars(), 2)}
    {set $language = ''}
{/if}
{def $countryList = fetch_country_list( hash( 'countryCode', $localeArray[1]|upcase,
                                              'languageCode', $language ) )}
<select name="countrylist_{$attribute.id}" id="countrylist_{$attribute.id}">
{foreach $countryList as $country}
    <option value="{$country.country_code}" {if $attribute.data_text|eq($country.country_code)}selected="selected"{/if}>{$country.translation}</option>
{/foreach}
</select>
