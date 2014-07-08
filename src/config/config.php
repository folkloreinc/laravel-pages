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
			'label' => trans('admin.pages_type_default'),
			'route' => array('pages.show.'.Config::get('app.locale'), function($page) {
				return array($page->locale->slug);
			})
		),
		'home' => array(
			'label' => trans('admin.pages_type_home'),
			'route' => 'home.'.Config::get('app.locale')
		),
		'news' => array(
			'label' => trans('admin.pages_type_news'),
			'route' => array('news.show.'.Config::get('app.locale'), function($page) {
				return array($page->created_at->format('Y'),$page->locale->slug);
			})
		),
		'contact' => array(
			'label' => trans('admin.pages_type_contact'),
			'route' => array('pages.show.'.Config::get('app.locale'), function($page) {
				return array($page->locale->slug);
			})
		),
		'item' => array(
			'label' => trans('admin.pages_type_item'),
			'route' => array('store.show.'.Config::get('app.locale'), function($page) {
				if($page->categories->isEmpty()) {
					return array('items',$page->locale->slug);
				} else {
					return array($page->categories->first()->locale->slug,$page->locale->slug);
				}
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
			'label' => trans('admin.pages_block_type_text')
		),
		'photos' => array(
			'label' => trans('admin.pages_block_type_photos')
		),
		'slideshow' => array(
			'label' => trans('admin.pages_block_type_slideshow')
		)
	),

	/*
	*
	* Block areas
	*
	*/
	'block_areas' => array(
		'slideshow' => array(
			'label' => trans('admin.pages_block_area_slideshow')
		),
		'left' => array(
			'label' => trans('admin.pages_block_area_left')
		),
		'right' => array(
			'label' => trans('admin.pages_block_area_right')
		)
	)


);
