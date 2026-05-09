<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Cliente extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'telefone',
        'endereco',
    ];

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }
}
