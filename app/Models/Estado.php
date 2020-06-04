<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Pais;

class Estado extends Model
{
    protected $table = 'estados';

    protected $fillable =
    [
        'estado',
        'pais_id' ,
        'uf',
    ];

    protected Pais $pais;

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_alteracao';

    public function setPais(Pais $pais) {
        $this->pais = $pais;
    }
}
