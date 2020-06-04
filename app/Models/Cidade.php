<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $table = 'cidades';

    protected $fillable =
    [
        'cidade',
        'estado_id',
        'ddd',
    ];

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
}
