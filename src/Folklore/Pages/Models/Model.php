<?php namespace Folklore\Pages\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    public function __construct(array $attributes = array())
    {
        $this->table = \Config::get('pages.database_prefix').$this->table;

        parent::__construct($attributes);
    }
}
