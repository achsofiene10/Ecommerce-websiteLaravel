<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    //
    public function User(){
        return $this->belongsTo('App\User');
    }

    protected $casts = [
        'items' => 'array',
    ];
    protected $fillable = [
        'price_com','adresse','id_user','phone','items'
    ];
}
