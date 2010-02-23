=====================
CA COUNTRYLIST README
=====================

***************
* Description *
***************

CA Country list implements a datatype that provide a translated list of country.
When initializing the datatype it requests a webservice (provided by http://ws.geonames.org) to store all countries in the world.
When viewing the datatype it checks if there is a translation in the current locale. 
If no translations available there as fetched through the webservice.

Note : the datatype can collect information.

****************
* Installation *
****************

1°) Execute sql/mysql/mysql.sql

2°) Activate the extension in your site.ini

3°) Regenerate the autoloads

4°) Add the datatype to your content type and you're good to go :)