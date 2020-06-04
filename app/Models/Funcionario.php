<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'funcionarios';

    protected $guarded = ['id'];

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
}
