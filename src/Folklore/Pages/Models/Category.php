<?php namespace Folklore\Pages\Models;

use Folklore\EloquentLocalizable\LocalizableTrait;

class Category extends Model {

	use LocalizableTrait;

	protected $table = 'categories';

	protected $fillable = array(
		'type'
	);

	/*
	 *
	 * Relationships
	 *
	 */
	public function pages()
	{
		return $this->morphedByMany('Folklore\Pages\Models\Page', 'categorizable');
	}
	public function blocks()
	{
		return $this->morphedByMany('Folklore\Pages\Models\Block', 'categorizable');
	}

}
