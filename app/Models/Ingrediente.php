<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function platos()
    {
        return $this->belongsToMany(Plato::class,
            'plato_ingredientes',
            'id_ingrediente',
            'id_plato')
            ->withPivot('cantidad');
    }
}
