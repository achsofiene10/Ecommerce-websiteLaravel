<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'name_subcat','icon_subcat','idcat'
    ];
    public function category(){
        return $this->belongsTo('App\Category');
    }
    public function product(){
        return $this->hasMany('App\Product');
    }
}
