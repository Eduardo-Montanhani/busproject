<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UsuarioController extends Controller
{
    public function index()
    {
        $users = Usuario::all();
        // Retorna para a view do Inertia
        return Inertia::render('Dashboard', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:usuarios', // Validação do CPF (exatamente 11 números)
            'senha' => 'required|string|min:6', // Senha com no mínimo 6 caracteres
        ]);

        // Criação do usuário
        Usuario::create([
            'nome' => $request->nome, // Corrigido para pegar o valor de 'nome' correto
            'cpf' => $request->cpf,
            'senha' => Hash::make($request->senha), // Senha criptografada
        ]);

        // Redireciona para a lista de usuários com sucesso
        return redirect()->route('usuario.login')->with('success', 'Usuário criado com sucesso!');
    }

    public function destroy(string $id)
    {
        $poltrona = Usuario::findOrFail($id); // Encontra a poltrona pelo ID
        $poltrona->delete(); // Deleta a poltrona

        return redirect()->route('users.index')->with('success', 'Poltrona deletada com sucesso!');
    }
}
