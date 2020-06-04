<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    protected $table = 'formas_pagamento';

    protected $fillable =
    [
        'forma_pagamento',
    ];

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';
}
