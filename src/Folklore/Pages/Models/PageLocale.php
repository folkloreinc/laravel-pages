<?php namespace Folklore\Pages\Models;

use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

use Cviebrock\EloquentTaggable\Taggable;
use Cviebrock\EloquentTaggable\TaggableImpl;

class PageLocale extends Model implements SluggableInterface, Taggable {

	use SluggableTrait, TaggableImpl;

	protected $table = 'pages_locale';

	protected $fillable = array(
		'locale',
		'title',
		'subtitle',
		'body',
		'slug'
	);

	protected $hidden = array(
		'id',
		'page_id'
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

}
