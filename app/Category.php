<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
        'name_cat','icon_cat'
    ];
    public function subcategory(){
        return $this->hasMany('App\Subcategory');
    }
}
