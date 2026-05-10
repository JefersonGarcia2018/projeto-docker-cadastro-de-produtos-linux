<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use BelongsToTenant;
    use HasFactory;

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
