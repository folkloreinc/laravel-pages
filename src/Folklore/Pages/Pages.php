<?php namespace Folklore\Pages;

use Folklore\Pages\Models\Page;
use Folklore\Pages\Models\Block;
use Folklore\Pages\Models\Category;
use Folklore\Pages\Models\Picture;

class Pages {

	protected $app;

	protected $pageTypes = array();

	protected $blockTypes = array();

	protected $blockAreas = array();

	protected $pagesSlugsByHandle = null;

	public function __construct($app)
	{

		$this->app = $app;

	}

	public function addPageType($name, $opts)
	{
		$this->pageTypes[$name] = $opts;
	}

	public function addBlockType($name, $opts)
	{
		$this->blockTypes[$name] = $opts;
	}

	public function addBlockArea($name, $opts)
	{
		$this->blockAreas[$name] = $opts;
	}

	public function pageTypes()
	{
		return $this->pageTypes;
	}

	public function blockTypes()
	{
		return $this->blockTypes;
	}

	public function blockAreas()
	{
		return $this->blockAreas;
	}

	public function pageType($type)
	{
		return isset($this->pageTypes[$type]) ? $this->pageTypes[$type]:null;
	}

	public function blockType($type)
	{
		return isset($this->blockTypes[$type]) ? $this->blockTypes[$type]:null;
	}

	public function blockArea($area)
	{
		return isset($this->blockAreas[$area]) ? $this->blockAreas[$type]:null;
	}

	/**
	*
	* URL
	*
	*/
	public function url($page, $locale = null)
	{
		
		if(!$locale) {
			$locale = $this->app['config']->get('app.locale');
		}

		$pageType = $this->pageType($page->type);
		if(!$pageType || !isset($pageType['url'])) return null;

		$url = $pageType['url'];
		
		if(is_object($url) && $url instanceof \Closure)
		{
			return $url($page,$locale);
		}
		else
		{
			$route = (array)$url;
			return call_user_func_array(array($this->app['url'], 'route'), $route);
		}
	}

	/**
	*
	* Categories
	*
	*/
	public function categories($options = null)
	{

		$options = $this->buildCategoryOptions($options);
		$query = $this->buildCategoryQuery($options);

		return $query->get();
	}

	public function categoriesByType($options = null)
	{

		$options = $this->buildCategoryOptions($options);
		$query = $this->buildCategoryQuery($options);

		return $query->orderBy('type','asc')->get();
	}

	public function categoriesFromType($type, $options = null)
	{

		$options = $this->buildCategoryOptions($options);
		$query = $this->buildCategoryQuery($options);

		return $query->where('type',$type)->get();
	}

	/**
	 *
	 * Pages
	 *
	 */

	public function slugFromHandle($handle,$locale) {

		if(!$this->pagesSlugsByHandle) {
			$this->pagesSlugsByHandle = $this->getSlugsByHandle();
		}

		return isset($this->pagesSlugsByHandle[$handle][$locale]) ? $this->pagesSlugsByHandle[$handle][$locale]:null;

	}

	protected function getSlugsByHandle() {

		$pages = Page::with(array('locales'=>function($query) {
				$query->select('page_id','locale','slug');
			}))
			->select('id','handle')
			->get();

		$pagesSlugsByHandle = array();
		foreach($pages as $page) {
			$pagesSlugsByHandle[$page->handle] = array();
			foreach($page->locales as $locale) {
				$pagesSlugsByHandle[$page->handle][$locale->locale] = $locale->slug;
			}
		}

		return $pagesSlugsByHandle;
	}

	public function query($options = null) {

		$options = $this->buildPageOptions($options);
		$query = $this->buildPageQuery($options);

		return $query;
	}

	public function pages($options = null)
	{

		$options = $this->buildPageOptions($options);
		$query = $this->buildPageQuery($options);

		return $query->get();
	}

	public function pagesByType($type, $options = null)
	{

		$options = $this->buildPageOptions($options);
		$query = $this->buildPageQuery($options);

		return $query->orderBy('type','asc')->get();
	}

	public function pageBySlug($slug, $options = null)
	{

		$options = $this->buildPageOptions($options);
		$query = $this->buildPageQuery($options);

		$page = $query->whereHas('locales', function($q) use ($options, $slug)
		{
			$q->where('locale', '=', $options['locale']);
		    $q->where('slug', '=', $slug);

		})
		->first();

		return $page;
	}

	public function pageByHandle($handle, $options = null)
	{

		$options = $this->buildPageOptions($options);
		$query = $this->buildPageQuery($options);

		$page = $query->where('handle','=',$handle)
					->first();

		return $page;
	}

	public function pageById($id, $options = null)
	{

		$options = $this->buildPageOptions($options);
		$query = $this->buildPageQuery($options);

		$page = $query->where('id','=',$id)
					->first();

		return $page;
	}

	protected function buildPageOptions($options = null)
	{

		if(!$options) {
			$options = array();
		} else if(is_string($options)) {
			$options = array('locale' => $options);
		}

		$config = $this->app['config'];
		$classes = $config->get('pages::classes');

		$defaultOptions = array(
			'locale' => $config->get('app.locale'),
			'className' => $classes['Page']
		);

		$options = array_merge($defaultOptions,$options);
		if(!array_key_exists('with',$options)) {
			$options['with'] = array(
				'categories',
				'pictures'
			);
		}

		return $options;
	}

	protected function buildPageQuery($options = null)
	{

		$className = $options['className'];
		$query = $className::query();

		if($options['with']) {
			$query->with($options['with']);
		}

		if($options['locale']) {
			$query->withLocale($options['locale']);
		}

		if($options['with'] === 'blocks' || (is_array($options['with']) && in_array('blocks',$options['with']))) {
			$query->withBlocksLocale($options['locale']);
		}

		if($options['with'] === 'categories' || (is_array($options['with']) && in_array('categories',$options['with']))) {
			$query->withCategoriesLocale($options['locale']);
		}

		return $query;
	}

	protected function buildCategoryOptions($options = null)
	{

		if(!$options) {
			$options = array();
		} else if(is_string($options)) {
			$options = array('locale' => $options);
		}

		$defaultOptions = array(
			'locale' => $this->app['config']->get('app.locale')
		);

		$options = array_merge($defaultOptions,$options);

		return $options;
	}

	protected function buildCategoryQuery($options = null)
	{

		$query = Category::withLocale($options['locale']);

		return $query;
	}

}
