<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Produto extends Model
{
    use BelongsToTenant;
    
    protected $fillable = ['codigo', 'nome', 'preco', 'estoque'];
}
