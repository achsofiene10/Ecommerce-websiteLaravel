<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
        'name_cat','icon_cat'
    ];
    public function category(){
        return $this->hasMany('App\Subcategory');
    }
}
