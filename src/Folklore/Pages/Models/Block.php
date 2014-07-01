<?php namespace Folklore\Pages\Models;

use Folklore\Pages\Models\Traits\Localizable;
use Folklore\Pages\Models\Traits\Picturable;

class Block extends Model {

	use Localizable, Picturable;

	protected $table = 'blocks';

	protected $fillable = array(
		'handle',
		'type',
		'area',
		'data',
		'order'
	);

	protected $hidden = array(
		'page_id'
	);

	/*
	*
	* Relationships
	*
	*/
	public function page()
	{
		return $this->belongsTo('Folklore\Pages\Models\Page','page_id');
	}
	public function categories()
	{
		return $this->morphToMany('Folklore\Pages\Models\Category', 'categorizable')
					->withTimestamps();
	}

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

Block::created(function($item)
{
	if(empty($item->handle)) {
		$item->handle = $item->type.'_'.$item->id;
		$item->save();
	}
});
