<?php

namespace App\Http\Controllers;

use App\Models\Poltrona; // Importando o modelo Poltrona
use App\Models\Usuario;  // Importando o modelo Usuario

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'numero' => 'required|string|max:255|unique:poltronas,numero,NULL,id,onibus,' . $request->onibus,
            'onibus' => 'required|string|max:255',
            'usuario_id' => 'nullable|exists:usuarios,id',
        ]);

        // Criando a nova poltrona
        $poltrona = new Poltrona();
        $poltrona->numero = $request->numero;
        $poltrona->usuario_id = $request->usuario_id;
        $poltrona->onibus = $request->onibus;
        $poltrona->save(); // Salvando a poltrona no banco de dados

        // Redireciona para a lista de poltronas com uma mensagem de sucesso
        return redirect()->route('poltronas.index')->with('success', 'Poltrona cadastrada com sucesso!');
    }

    /**
     * Exibe a lista de poltronas cadastradas.
     */
    public function index()
    {
        // Ordena as poltronas pelo campo 'numero' de forma numérica, tratando como integer
        $poltronas = Poltrona::with('usuario')
            ->orderByRaw('CAST(numero AS UNSIGNED) ASC') // Força a ordenação numérica
            ->get();

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

    public function disponiveis(Request $request)
    {
        $onibus = $request->input('onibus', 'Onibus 1'); // Define um valor padrão caso não seja passado

        // Filtra as poltronas disponíveis e do ônibus selecionado
        $poltronas = Poltrona::whereNull('usuario_id')
            ->where('onibus', $onibus)
            ->orderByRaw('CAST(numero AS UNSIGNED) ASC') // Ordena numericamente
            ->get();

        return view('poltronas.disponiveis', compact('poltronas', 'onibus'));
    }


    public function reservar($id)
    {
        $usuarioId = \Illuminate\Support\Facades\Auth::id(); // Obtém o ID do usuário autenticado

        if (!$usuarioId) {
            return redirect()->route('usuario.login')->with('error', 'Você precisa estar logado para reservar uma poltrona.');
        }

        // Verifica se o usuário existe
        $usuario = Usuario::find($usuarioId);

        if (!$usuario) {
            return redirect()->route('usuario.login')->with('error', 'Usuário não encontrado.');
        }

        // Verifica se o usuário já tem uma poltrona associada
        if ($usuario->poltrona()->exists()) {
            return redirect()->route('poltronas.disponiveis')->with('error', 'Você já reservou uma poltrona!');
        }

        $poltrona = Poltrona::findOrFail($id); // Busca a poltrona pelo ID

        // Verifica se a poltrona já foi reservada
        if ($poltrona->usuario_id) {
            return redirect()->route('poltronas.disponiveis')->with('error', 'Essa poltrona já foi reservada.');
        }

        // Associa a poltrona ao usuário logado
        $poltrona->usuario_id = $usuarioId;
        $poltrona->save();

        return redirect()->route('poltronas.disponiveis')->with('success', 'Poltrona reservada com sucesso!');
    }
    public function filter(Request $request)
    {
        // Obtendo o parâmetro 'onibus' da URL ou utilizando 'Onibus 1' como valor padrão
        $onibus = $request->input('onibus', 'Onibus 1');

        // Filtrando as poltronas com base no ônibus selecionado
        $poltronas = Poltrona::where('onibus', $onibus)
            ->orderByRaw('CAST(numero AS UNSIGNED) ASC') // Ordenação numérica das poltronas
            ->get();

        // Retornando as poltronas filtradas para a view
        return view('poltronas.index', compact('poltronas', 'onibus'));
    }
}
