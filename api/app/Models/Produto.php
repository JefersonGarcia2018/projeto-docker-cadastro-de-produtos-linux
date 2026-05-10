<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produto extends Model
{
    use BelongsToTenant;
    use HasFactory;
    
    protected $fillable = ['codigo', 'nome', 'preco', 'estoque'];
}
