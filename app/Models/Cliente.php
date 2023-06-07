<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cliente';

    protected $fillable = [
        'nome',
        'email',
        'dataNascimento',
        'endereco',
        'complemento',
        'bairro',
        'cep',
    ];

    public function pedidos()
    {
        return $this->hasOne(Cliente::class, 'cliente_id');
    }
}
