<?php



return array(

	/*
	*
	* Database Prefix
	*
	*/
	'database_prefix' => '',

	/*
	*
	* Locale
	*
	*/
	'locale' => 'default',

	'locale_available' => array(
		'fr',
		'en'
	),
	
	
	'classes' => array(
		'Page' => '\Folklore\Pages\Models\Page'
	),

	/*
	*
	* Page types
	*
	*/
	'page_types' => array(
		'default' => array(
			'label' => 'default',
			'route' => array('page.'.Config::get('app.locale'), function($page) {
				return array($page->locale->slug);
			})
		)
	),

	/*
	*
	* Block types
	*
	*/
	'block_types' => array(
		'text' => array(
			'label' => 'Text'
		)
	),

	/*
	*
	* Block areas
	*
	*/
	'block_areas' => array(
		'main' => array(
			'label' => 'Main'
		)
	)


);
