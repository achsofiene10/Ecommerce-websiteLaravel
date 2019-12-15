<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'idsouscat','title','details','price','status','img_product','os_product','Ram_product','compagny'
    ];

    public function subcategory(){
        return $this->belongsTo('App\Subcategory');
    }

}
