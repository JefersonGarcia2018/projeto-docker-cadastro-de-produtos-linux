<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Veiculo extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'cliente_id',
        'placa',
        'marca',
        'modelo',
        'ano',
        'cor',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
