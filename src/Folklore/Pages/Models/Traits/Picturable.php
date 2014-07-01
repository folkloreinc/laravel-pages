<?php namespace Folklore\Pages\Models\Traits;

use Folklore\Pages\Models\Picture;

trait Picturable {

    protected $picturable_order = true;

    /*
     *
     * Relationships
     *
     */
    public function pictures()
    {
        $query = $this->morphMany('Folklore\Pages\Models\Picture','picturable');

        if($this->picturable_order)
        {
            $query->orderBy('picturable_order','asc');
        }

        return $query;
    }

    /*
     *
     * Sync methods
     *
     */
    public function syncPictures($pictures = array()) {

        if(is_array($pictures) && sizeof($pictures))
        {
            $ids = array();
            $pictureOrder = 0;
            foreach($pictures as $data)
            {
                $picture = Picture::find($data);

                if(!$picture)
                {
                    continue;
                }

                //Update order
                if($this->picturable_order && (int)$picture->picturable_order != $pictureOrder)
                {
                    $picture->fill(array(
                        'picturable_order' => $pictureOrder
                    ));
                    $picture->save();
                }

                $this->pictures()->save($picture);

                $ids[] = $picture->id;
                $pictureOrder++;
            }

            //Delete other pictures
            $picturesToDelete = $this->pictures()
                                    ->whereNotIn('id',$ids)
                                    ->get();
            foreach($picturesToDelete as $picture)
            {
                $picture->delete();
            }
        }
        else
        {
            foreach($this->pictures as $picture)
            {
                $picture->delete();
            }
        }

    }

}
