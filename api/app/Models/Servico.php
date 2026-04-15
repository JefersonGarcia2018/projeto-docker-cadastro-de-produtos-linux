<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Servico extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'descricao',
        'valor_padrao',
        'tempo_estimado_minutos',
    ];
}
