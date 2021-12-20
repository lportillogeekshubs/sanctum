<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatoIngrediente extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_plato',
        'id_ingrediente',
        'cantidad',
    ];
}
