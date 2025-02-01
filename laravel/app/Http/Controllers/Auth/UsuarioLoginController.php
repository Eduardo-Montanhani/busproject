<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioLoginController extends Controller
{
    public function login(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'cpf' => 'required',
            'senha' => 'required|min:6',
        ]);

        // Busca o usuário pelo CPF
        $usuario = Usuario::where('cpf', $request->cpf)->first();

        // Se o usuário não for encontrado
        if (!$usuario) {
            return redirect()->back()->withErrors(['cpf' => 'CPF não encontrado']);
        }

        // Verifica se a senha está correta
        if (!Hash::check($request->senha, $usuario->senha)) {
            return redirect()->back()->withErrors(['senha' => 'Senha incorreta']);
        }

        // Autentica o usuário
        Auth::guard('usuarios')->login($usuario);

        // Redireciona para a página de poltronas disponíveis
        return redirect()->route('poltronas.disponiveis')->with('message', 'Login realizado com sucesso');
    }

}
