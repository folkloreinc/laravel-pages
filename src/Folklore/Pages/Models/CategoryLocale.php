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
	 * Accessors and mutators
	 *
	 */
	protected function setTitleAttribute($value)
	{
		$this->attributes['title'] = $value;
		$this->attributes['slug'] = Str::slug($value);
	}

}
