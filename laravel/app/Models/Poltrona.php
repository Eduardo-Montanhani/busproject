<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poltrona extends Model
{
    use HasFactory;

    // Defina os campos que podem ser preenchidos
    protected $fillable = ['numero', 'usuario_id', 'onibus'];

    // Relacionamento com o modelo Usuario (um usuário pode ter várias poltronas)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id'); // Uma poltrona pertence a um usuário
    }
}
