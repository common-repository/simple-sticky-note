=== Simple Sticky Note ===
Contributors: sharkthemes, amitpomu
Tags: Sticky Note, Frontend Sticky Note
Donate link: http://sharkthemes.com
Requires PHP: 5.6
Requires at least: 5.0
Tested up to: 6.3
Stable tag: 1.0.7
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Add a instant short note, quote or any sensative short data for your self or everyone from frontend.

== Description ==
	Add a instant short note, quote or any sensative short data for your self or everyone from frontend. You do not have to take hassle to create post. It can be useful for your daily work routine, personal data collection or brainy quotes showcase.

== Installation ==
	= Using The WordPress Dashboard =
	* Navigate to the 'Add New' in the plugins dashboard
	* Search for Simple Sticky Note
	* Click Install Now
	* Activate the plugin on the Plugin dashboard
	= Uploading in WordPress Dashboard =
	* Navigate to the 'Add New' in the plugins dashboard
	* Navigate to the 'Upload' area
	* Select st-sticky-note.zip from your computer
	* Click 'Install Now'
	* Activate the plugin in the Plugin dashboard
	= Using FTP =
	* Download st-sticky-note.zip
	* Extract the st-sticky-note directory to your computer
	* Upload the st-sticky-note directory to the /wp-content/plugins/ directory
	* Activate the plugin in the Plugin dashboard
	= Permalink Setup =
	* Go to Settings -> Permalinks and click on "Save Changes" if your sticky notes does not display ( Conditional )


== A Brief Note ==

	= Customization and Flexibility =
		Since sticky notes are displayed in grids, It gives you liberty to select column option from 1 to 6 column. It is fully responsive, therefore you won't have any problem going through in any device.

	= Shortcodes =
		Defaults Atts :-
		* column = 3 ( max num value 6 )

		Sticky Note Shortcode:
		[ST_STICKY_NOTE] OR [ST_STICKY_NOTE column="3"]

	= Setup =
		* As you install and activate plugin 
		* Note: Only Administrator Role can create the sticky note
		* Create a page for sticky note ( Note: Make visibility private if you don't want others to see the notes )
		* Add shortcode to initialize the Sticky Note Page
		* Save and view the page.

	= How to use =
		* As you create page, view the page
		* Click on Note Title to add a note
		* After you add title and content you just need to click outside the form to save
		* Double click to edit or delete

	= For Developers =
		= If there is multiple Administrators and use sticky note page for personal use and only show personal notes as user logged in =
		* Add the following code in your theme/website 
		
		function author_filter_function(){
			return true;
		}
		add_filter( 'st_sticky_note_filter_by_author', 'author_filter_function' );


    
== Copyright ==

	Simple Sticky Note WordPress Plugin, Copyright 2020, Shark Themes
	Link: http://www.sharkthemes.com/downloads/simple-sticky-note/

	Packery PACKAGED v2.1.1 Copyright 2016 Metafizzy
	License: GPLv3 for open source use
	Source: http://packery.metafizzy.co


== Changelog ==

	= 1.0.0 Jan 06 2020 =
	* Initial release.

	= 1.0.1 Jan 30 2020 =
	* Documentation Update

	= 1.0.2 Dec 10 2020 =
	* Jquery issue updated ( .live fuction )

	= 1.0.3 Nov 21 2021 =
	* Compatibility check
	* Minor Code Update

	= 1.0.4 Jan 31 2022 =
	* Compatibility check
	* Minor Design Update
	* Added TinyMCE for textarea

	= 1.0.5 Jun 07 2022 =
	* Compatibility check

	= 1.0.6 Mar 30 2023 =
	* Compatibility check

	= 1.0.7 Aug 12 2023 =
	* Compatibility check
	* Authority code update


== Upgrade Notice ==

	= 1.0.0 =
	* Initial release.

	= 1.0.1 =
	* Documentation Update

	= 1.0.2 =
	* Jquery issue updated ( .live fuction )

	= 1.0.3 =
	* Compatibility check
	* Minor security code update

	= 1.0.4 =
	* Compatibility check
	* Minor Design Update
	* Added TinyMCE for textarea

	= 1.0.5 =
	* Compatibility check

	= 1.0.6 =
	* Compatibility check

	= 1.0.7 =
	* Compatibility check
	* Authority code update

