<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Produto;
use App\Models\Cliente;

class Pedido extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pedido';

    protected $fillable = [
        'produto_id',
        'cliente_id',
    ];

    public function produto()
    {
        return $this->hasMany(Produto::class, 'produto_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
