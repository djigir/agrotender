<?php

namespace App\Models\ADV;

use Illuminate\Database\Eloquent\Model;

class AdvTorgPostPics extends Model
{
    protected $table = 'adv_torg_post_pics';

    public $timestamps = false;

    protected $fillable = [
        'file_id', 'item_id', 'prevload', 'sesid',
        'requid', 'qquuid', 'filename', 'filename_big',
        'filename_thumb', 'filename_ico', 'title', 'sort_num',
        'ico_w', 'ico_h', 'thumb_w', 'thumb_h', 'big_w', 'big_h',
        'src_w', 'src_h', 'add_date'
    ];




/*     public function getImage($number)
     {
         return AdvTorgPostPics::query()->where('item_id',$this->item_id)->select('filename_ico')
             ->take(1)
             ->skip($number)->first()->filename_ico;

     }*/

    public function getImagesAttribute($key)
    {
        $pics = AdvTorgPostPics::query()->where('item_id',$this->item_id)->select('filename_ico')->get();
        $images = '';

        foreach ($pics as $pic)
        {
            $images.=$pic->filename_ico.',';
        }
        return $images;


    }
}
