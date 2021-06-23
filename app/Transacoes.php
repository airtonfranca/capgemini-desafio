<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Transacoes extends Model
{
    use Notifiable;

//    public $timestamps = true;

    protected $fillable = [
        'user_id', 'tipo', 'valor',
    ];

}
