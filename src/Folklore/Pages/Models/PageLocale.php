<?php namespace Folklore\Pages\Models;

use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class PageLocale extends Model implements SluggableInterface {

	use SluggableTrait;

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

}
