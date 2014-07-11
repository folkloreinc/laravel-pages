<?php namespace Folklore\Pages\Models;

use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class CategoryLocale extends Model implements SluggableInterface {

	use SluggableTrait;

	protected $table = 'categories_locale';

	protected $fillable = array(
		'locale',
		'title'
	);

	protected $hidden = array(
		'id'
	);

	protected $sluggable = array(
		'build_from' => 'title',
		'save_to'    => 'slug',
		'on_update' => true
	);
	
	/*
	*
	* Override EloquentSluggable::getExistingSlugs() to take into account the current locale
	*
	*/
	protected function getExistingSlugs($slug)
	{
		$save_to         = $this->sluggable['save_to'];
		$include_trashed = $this->sluggable['include_trashed'];

		$instance = new static;

		$query = $instance->where( $save_to, 'LIKE', $slug.'%' );
		
		if(!empty($this->locale)) {
			$query->where( 'locale', $this->locale);
		}

		// include trashed models if required
		if ( $include_trashed )
		{
			$query = $query->withTrashed();
		}

		// get a list of all matching slugs
		$list = $query->lists($save_to, $this->getKeyName());

		return $list;
	}

	/*
	 *
	 * Accessors and mutators
	 *
	 */
	protected function setTitleAttribute($value)
	{
		$this->attributes['title'] = $value;
		$this->attributes['slug'] = Str::slug($value);
	}

}
