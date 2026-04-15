<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['razao_social', 'cnpj', 'status_assinatura'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
