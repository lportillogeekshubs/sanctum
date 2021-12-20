<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPlato extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function platos()
    {
        return $this->hasMany(Plato::class, 'id_tipo_plato');
    }
}
