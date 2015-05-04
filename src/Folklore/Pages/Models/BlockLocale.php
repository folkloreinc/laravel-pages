<?php namespace Folklore\Pages\Models;

use Illuminate\Support\Str;

use Cviebrock\EloquentTaggable\Taggable;
use Cviebrock\EloquentTaggable\TaggableImpl;

class BlockLocale extends Model implements Taggable {
	
	use TaggableImpl;

	protected $table = 'blocks_locale';

	protected $fillable = array(
		'locale',
		'title',
		'subtitle',
		'body',
		'data'
	);

	protected $hidden = array(
		'block_id'
	);

	/*
	 *
	 * Accessors and mutators
	 *
	 */
	protected function setDataAttribute($value)
	{
		$this->attributes['data'] = is_array($value) ? json_encode($value):$value;
	}
	protected function getDataAttribute($value)
	{
		if(empty($value)) {
			return array();
		}
		return !is_array($value) ? @json_decode($value):$value;
	}

}
