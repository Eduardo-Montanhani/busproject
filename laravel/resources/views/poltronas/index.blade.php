
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-black shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">Usuários Cadastrados</h3>
                    <table class="min-w-full mt-4 border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b p-2">Nome</th>
                                <th class="border-b p-2">CPF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td class="border-b p-2">{{ $user->nome }}</td>
                                    <td class="border-b p-2">{{ $user->cpf }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="border-b p-2 text-center">Nenhum usuário encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <h3 class="text-lg font-semibold mt-6">Poltronas Cadastradas</h3>
                    <table class="min-w-full mt-4 border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b p-2">Número da Poltrona</th>
                                <th class="border-b p-2">Usuário Associado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($poltronas as $poltrona)
                                <tr>
                                    <td class="border-b p-2">{{ $poltrona->numero }}</td>
                                    <td class="border-b p-2">
                                        {{ $poltrona->usuario ? $poltrona->usuario->nome : 'Nenhum usuário associado' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="border-b p-2 text-center">Nenhuma poltrona encontrada.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

