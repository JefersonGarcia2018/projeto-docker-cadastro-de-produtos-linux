<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Veiculo extends Model
{
    use BelongsToTenant;
    use HasFactory;

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
