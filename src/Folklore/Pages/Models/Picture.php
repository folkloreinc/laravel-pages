<?php namespace Folklore\Pages\Models;

class Picture extends Model {

    protected $table = 'pictures';

    protected $guarded = array();
    protected $fillable = array(
        'picturable_order',
        'picturable_position',
        'filename',
        'original',
        'mime',
        'size',
        'width',
        'height'
    );

    public function picturable()
    {
        return $this->morphTo();
    }


}

//Delete files when model is deleted
Picture::deleting(function($item)
{
    $path = \Config::get('pages::pictures_path');

    $path = $path.'/'.$item->filename;
    if(file_exists($path)) {
        \Image::delete($path);
    }
    return true;
});
