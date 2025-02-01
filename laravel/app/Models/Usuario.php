<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Usuario extends Model implements Authenticatable
{
    use AuthenticableTrait; // Necessário para usar os métodos da interface

    protected $fillable = [
        'nome',
        'cpf',
        'senha',
    ];
    // Defina o guard aqui se quiser
    protected $guard = 'usuarios'; // Isso garante que esse modelo usará o guard correto
    // O método getAuthIdentifierName() retorna o nome do campo que será utilizado para identificar o usuário
    public function getAuthIdentifierName()
    {
        return 'id'; // ou outro campo, se estiver utilizando outro campo como identificador
    }

    // O método getAuthIdentifier() retorna o valor do campo de identificação do usuário
    public function getAuthIdentifier()
    {
        return $this->getKey(); // Retorna o valor do campo primário (id)
    }

    // O método getAuthPassword() retorna a senha do usuário
    public function getAuthPassword()
    {
        return $this->senha; // Retorna o campo de senha
    }

    // Para o "remember me", você pode configurar um campo de token, por exemplo
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function poltronas()
    {
        return $this->hasMany(Poltrona::class);
    }
}
