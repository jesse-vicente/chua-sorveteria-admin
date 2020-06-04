<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';

    protected $fillable =
    [
        'pais' ,
        'sigla',
        'ddi',
    ];

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
}
