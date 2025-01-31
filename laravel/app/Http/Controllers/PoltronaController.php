<?php

namespace App\Http\Controllers;

use App\Models\Poltrona; // Importando o modelo Poltrona
use App\Models\Usuario;  // Importando o modelo Usuario
use Illuminate\Http\Request;
use Inertia\Inertia;

class PoltronaController extends Controller
{
    /**
     * Exibe o formulário para criar uma nova poltrona.
     */
    public function create()
    {
        $usuarios = Usuario::all(); // Obtém todos os usuários para associar a uma poltrona
        return view('poltronas.create', compact('usuarios')); // Passa os usuários para a view
    }

    /**
     * Armazena uma nova poltrona no banco de dados.
     */
    public function store(Request $request)
    {
        // Validando o número da poltrona e o usuário
        $request->validate([
            'numero' => 'required|unique:poltronas,numero|integer',
            'usuario_id' => 'nullable|exists:usuarios,id', // O usuário é opcional, mas se for passado, deve existir
        ]);

        // Criando a nova poltrona
        $poltrona = new Poltrona();
        $poltrona->numero = $request->numero;
        $poltrona->usuario_id = $request->usuario_id;
        $poltrona->save(); // Salvando a poltrona no banco de dados

        // Redireciona para a lista de poltronas com uma mensagem de sucesso
        return redirect()->route('poltronas.index')->with('success', 'Poltrona cadastrada com sucesso!');
    }

    /**
     * Exibe a lista de poltronas cadastradas.
     */
    public function index()
    {
        $poltronas = Poltrona::with('usuario')->get(); // Recupera todas as poltronas com a relação do usuário
        $usuarios = Usuario::all(); // Obtém todos os usuários
        return Inertia::render('Dashboard', [
            'poltronas' => $poltronas,
            'usuarios' => $usuarios, // Passa os usuários para a view
        ]);
    }

    /**
     * Exibe os detalhes de uma poltrona específica.
     */

    public function destroy(string $id)
    {
        $poltrona = Poltrona::findOrFail($id); // Encontra a poltrona pelo ID
        $poltrona->delete(); // Deleta a poltrona

        return redirect()->route('poltronas.index')->with('success', 'Poltrona deletada com sucesso!');
    }
}
