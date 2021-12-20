<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plato extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_tipo_plato',
        'nombre',
        'comensales',
    ];

    public function tipoPlato()
    {
        return $this->hasOne(TipoPlato::class, 'id', 'id_tipo_plato');
    }

    public function tipoPlatoInv()
    {
        return $this->belongsTo(TipoPlato::class, 'id_tipo_plato');
    }

    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class,
            'plato_ingredientes',
            'id_plato',
            'id_ingrediente')
            ->withPivot('cantidad');
    }

}
