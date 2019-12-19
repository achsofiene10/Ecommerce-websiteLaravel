<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    public function User(){
        return $this->belongsTo('App\User');
    }
    protected $casts = [
        'items' => 'array',
    ];
    protected $fillable = [
        'Price','items','id_user'
    ];

}
