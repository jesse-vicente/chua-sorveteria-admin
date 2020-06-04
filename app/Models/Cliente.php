<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $guarded = ['id'];

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
}
