=== Memsource Translation Plugin for WordPress ===
Contributors: memsource
Tags: memsource, wpml, translation, localization, localisation, multilingual
Requires at least: 3.7
Requires PHP: 5.6
Tested up to: 5.1
Stable tag: trunk
License: GPLv2 or later

== Description ==

The Memsource Translation Plugin, which enables the Memsource Connector for WordPress, provides a fast, efficient way to localize pages, posts, tags and categories while preserving the original formatting, graphics, and layout. By integrating the plugin and connector, you can take full advantage of the tools available in Memsource’s powerful translation platform and streamline your translation process.

= Features =

* Translate pages and posts - web pages are pulled into Memsource, analyzed, and converted into a translation-friendly format. The latest version of the Memsource Translation Plugin for WordPress (v. 2.0) also supports translation for tags and categories.
* Automated Translations - Updated WordPress content can be automatically detected, translated, and pushed back into WordPress as a draft or published page with images and formatting preserved.
* Support for visual page builders - The latest version of the Memsource Translation Plugin for WordPress (v. 2.0) now supports Divi, Avada, and Visual Composer page builders.
* Custom Shortcodes - After building a custom shortcode in a third party plugin, you can now add it to your WordPress site with our shortcode editor and translate your shortcode content.

Learn more about the Memsource Translation Plugin for WordPress in the [Memsource documentation](https://wiki.memsource.com/wiki/WordPress_Plugin#Setting_up_the_Memsource_Translation_Plugin_for_WordPress_in_Memsource_Cloud).

== FAQ ==

Further information on the Memsource Translation Plugin for WordPress can be found [here](https://wiki.memsource.com/wiki/WordPress_Plugin#Setting_up_the_Memsource_Translation_Plugin_for_WordPress_in_Memsource_Cloud).

= Installation Instructions =

Before you begin, check that your WordPress website has a [WPML plugin](https://wpml.org/) to manage multilingual pages. The languages in WPML must match the project languages.

1. To add the Memsource Translation Plugin to your WordPress site, log into your Dashboard, go to **Plugins**, and Select **Add New**.
2. On the plugin page, search for **Memsource Translation Plugin** and click **Install Now**.
3. Hover over the installed Memsource plugin in the left-hand navigation, click **Connector** and then click **Show Connector settings**. A unique token will have been generated. You will need this token to set up the connector in Memsource Cloud.

= Setting up the Memsource Translation Plugin for Wordpress in Memsource Cloud =

1. Go to Setup -> Integrations -> Connectors, and click on **New** to set up a new connector.
2. Select the **WordPress** option.
3. Add your WordPress site **URL prefix** to the WordPress site URL field. For example, if your WordPress admin page URL is ​http://blog.memsource.com/wp-admin/index.php, the prefix would be ​http://blog.memsource.com/.
4. Copy the token from the WordPress Admin page and paste it into the **Memsource WordPress plugin token** field.
5. Click **Test connection**. Memsource Cloud should connect to your WordPress site and display a list of languages configured by the WPML plugin. If the WPML plugin is not found, an error message will appear.
6. If everything is OK, save the connector.
7. The content from WordPress can be imported either manually using the [Add from Online Repository](https://wiki.memsource.com/wiki/Connectors#Creating_New_Jobs_from_Online_Repositories) button or [automatically](https://wiki.memsource.com/wiki/Automated_Project_Creation).

== Changelog ==

= 2.7 =
*Release Date - 31 Jul 2019*

* Fix decoding of translated category.

= 2.6 =
*Release Date - 28 May 2019*

* Add pagination to the translatable content page.
* Create valid link in the JSON response.

= 2.5 =
*Release Date - 1 April 2019*

* Change contact e-mail address.

= 2.4.6 =
*Release Date - 28 January 2019*

* Fixed filtering of empty posts.

= 2.4.5 =
*Release Date - 20 December 2018*

* Fixed processing of shortcodes.
* Allowed translation of hidden languages.

= 2.4.4 =
*Release Date - 22 November 2018*

* Fixed an issue with listing posts without content.
* Added more information to the debug log.

= 2.4.3 =
*Release Date - 11 September 2018*

* Fixed an issue with Fusion Builder and translation upload.

= 2.4.2 =
*Release Date - 2 July 2018*

* Fixed an issue with Fusion Builder and Base64 encoded content.

= 2.4.1 =
*Release Date - 5 June 2018*

* Fixed a rare bug that affected loading shortcode definitions.

= 2.4 =
*Release Date - 31 May 2018*

* Added Avia Layout Builder support.

= 2.3.1 =
*Release Date - 29 May 2018*

* Added more data to debug visual editor issues.

= 2.3 =
*Release Date - 18 May 2018*

* Memsource Connector supports WordPress custom types now.

= 2.2.2 =
*Release Date - 4 May 2018*

* Fixed another database issue.

= 2.2.1 =
*Release Date - 17 April 2018*

* Fixed an occasional database issue.

= 2.2 =
*Release Date - 4 April 2018*

* Added a new admin page to select translatable custom fields.
* Fixed an issue with certain shortcode definitions.

= 2.1.1 =
*Release Date - 23 February 2018*

* Fixed max length of language mapping codes.

= 2.1 =
*Release Date - 21 February 2018*

* Added "Language mapping" page to map WPML locale codes to their Memsource counterparts.
* Fixed several bugs in visual editor shortcode parsers.

= 2.0.2 =
*Release Date - 27 November 2017*

* Fixed "Index column size too large" issue on some MySQL configurations using utf8mb4 character set.

= 2.0.1 =
*Release Date - 8 November 2017*

* Fixed an occasional bug with loading shortcode definitions.

= 2.0 =
*Release Date - 7 November 2017*

* The plugin now works with categories, tags and visual editor shortcodes (Visual Composer, Avada, Divi). Also the user interface was improved.

= 1.2.3 =
*Release Date - 24 August 2017*

* Fixed a small bug with including a third party library.

= 1.2.2 =
*Release Date - 18 August 2017*

* Added a simple logging system to debug the plugin and send reports.

= 1.2.1 =
*Release Date - 25 April 2017*

* Fixed the WPML plugin detection.

= 1.2 =
*Release Date - 15 November 2016*

* Added options to list posts with selected statuses (publish, draft).
* Added options to insert translations with a selected status (publish, draft).

= 1.1.3 =
*Release Date - 20 October 2016*

* Fixed list of all posts.

= 1.1.2 =
*Release Date - 15 October 2016*

* Fixed authentication token generator.

= 1.1.1 =
*Release Date - 12 October 2016*

* Fixed storing ID of the last processed post.

= 1.1 =
*Release Date - 12 October 2016*

* List and Get methods return posts with the last revision content.
* Translation can be inserted as a draft.
* Minor UI improvements.
* A better description added to readme.txt

= 1.0.4 =
*Release Date - 4 October 2016*

* Added readme.txt.

= 1.0.3 =
*Release Date - 3 October 2016*

* Fixed a bug with the last processed post ID.

= 1.0.2 =
*Release Date - 1 October 2016*

* Fixed a bug at JSON response of the translation endpoint.

= 1.0.1 =
*Release Date - 29 September 2016*

* Added i18n strings.

= 1.0 =
*Release Date - 28 September 2016*

* Initial version.
