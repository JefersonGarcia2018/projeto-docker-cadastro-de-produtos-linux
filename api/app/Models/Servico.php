<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servico extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $fillable = [
        'descricao',
        'valor_padrao',
        'tempo_estimado_minutos',
    ];
}
