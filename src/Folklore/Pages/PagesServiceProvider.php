<?php namespace Folklore\Pages;

use Illuminate\Support\ServiceProvider;

class PagesServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		
		// Config file path
		$configFile = __DIR__ . '/../../config/config.php';
		$migrationsPath = __DIR__ . '/../../migrations/';

		// Merge files
		$this->mergeConfigFrom($configFile, 'pages');

		// Publish
		$this->publishes([
			$configFile => config_path('pages.php')
		], 'config');

		$this->publishes([
			$migrationsPath => database_path('migrations')
		], 'migrations');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->registerPicturable();

		$this->registerSluggable();

		$this->registerPages();
	}

	/**
	* Register the sluggable service provider
	*
	* @return void
	*/
	protected function registerPicturable()
	{

		$this->app->register('Folklore\EloquentPicturable\PicturableServiceProvider');

	}

	/**
	* Register the sluggable service provider
	*
	* @return void
	*/
	protected function registerSluggable()
	{

		$this->app->register('Cviebrock\EloquentSluggable\SluggableServiceProvider');

	}

	/**
	 * Register the plume class used by the facade
	 *
	 * @return void
	 */
	protected function registerPages()
	{
		$this->app['pages'] = $this->app->share(function($app)
		{
			$pages = new Pages($app);

			$config = $app['config'];

			$pageTypes = $config->get('pages.page_types');
			if($pageTypes && sizeof($pageTypes)) {
				foreach($pageTypes as $name => $opts) {
					$pages->addPageType($name,$opts);
				}
			}

			$blockTypes = $config->get('pages.block_types');
			if($blockTypes && sizeof($blockTypes)) {
				foreach($blockTypes as $name => $opts) {
					$pages->addBlockType($name,$opts);
				}
			}

			$blockAreas = $config->get('pages.block_areas');
			if($blockAreas && sizeof($blockAreas)) {
				foreach($blockAreas as $name => $opts) {
					$pages->addBlockArea($name,$opts);
				}
			}

			return $pages;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('pages');
	}

}
