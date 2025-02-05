import { useState, useEffect } from 'react';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Link } from '@inertiajs/react';
import { Head } from '@inertiajs/react';

export default function Dashboard({ users, poltronas }) {
    const [selectedTab, setSelectedTab] = useState('users'); // Estado para controlar a aba selecionada
    // Função para formatar um CPF (assumindo que seja uma string com 11 dígitos)
    const formatCPF = (cpf) => {
        if (!cpf) return '';
        return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    };


    // Função para alternar entre as abas e atualizar a URL
    const handleTabClick = (tab) => {
        setSelectedTab(tab);
        const url = tab === 'users' ? '/users' : '/poltronas';
        Inertia.visit(url, { preserveState: false, replace: true }); // Usando replace para garantir que a URL seja atualizada
    };
    const handleDeletePoltrona = (id) => {
        if (confirm("Tem certeza que deseja excluir esta poltrona?")) {
            Inertia.delete(`/poltronas/${id}`, {
                onSuccess: () => {
                    alert("Poltrona excluída com sucesso!");
                },
                onError: (errors) => {
                    alert("Erro ao excluir a poltrona.");
                    console.error(errors);
                }
            });
        }
    };
    const handleDeleteUser = (id) => {
        if (confirm("Tem certeza que deseja excluir este usuario ?")) {
            Inertia.delete(`/users/${id}`, {
                onSuccess: () => {
                    alert("Usuario excluido com sucesso!");
                },
                onError: (errors) => {
                    alert("Erro ao excluir usuario.");
                    console.error(errors);
                }
            });
        }
    };


    useEffect(() => {
        // Verifica se a URL já possui o parâmetro correto de aba e ajusta o estado
        const currentPath = window.location.pathname;
        if (currentPath === '/users') {
            setSelectedTab('users');
        } else if (currentPath === '/poltronas') {
            setSelectedTab('poltronas');
        }
    }, []); // Isso roda uma vez ao montar o componente

    return (
        <AuthenticatedLayout
            header={<h2 className="text-xl font-semibold text-white">Dashboard</h2>}
        >
            <Head title="Dashboard" />
            <div className="py-12 bg-gray-900">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-gray-800 shadow-sm sm:rounded-lg">
                        <div className="p-6 text-white">
                            {/* Botões para alternar entre as abas */}
                            <div className="flex mb-4">
                                <button
                                    onClick={() => handleTabClick('users')}
                                    className={`mr-4 px-4 py-2 text-sm font-semibold rounded-lg ${selectedTab === 'users' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300'} hover:bg-blue-700`}
                                >
                                    Usuários
                                </button>
                                <button
                                    onClick={() => handleTabClick('poltronas')}
                                    className={`px-4 py-2 text-sm font-semibold rounded-lg ${selectedTab === 'poltronas' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300'} hover:bg-blue-700`}
                                >
                                    Poltronas
                                </button>
                            </div>

                            {/* Exibir dados de Usuários ou Poltronas, dependendo da aba selecionada */}
                            {selectedTab === 'users' && (
                                <>
                                    <h3 className="text-lg font-semibold">Usuários Cadastrados</h3>
                                    <table className="min-w-full mt-4 border-collapse text-gray-300">
                                        <thead>
                                            <tr>
                                                <th className="border-b p-2">Nome</th>
                                                <th className="border-b p-2">CPF</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {Array.isArray(users) && users.length > 0 ? (
                                                users.map((user) => (
                                                    <tr key={user.id}>
                                                        <td className="border-b p-2">{user.nome}</td>
                                                        <td className="border-b p-2">{formatCPF(user.cpf)}</td>
                                                        <td className="border-b p-2 text-center">
                                                            <button
                                                                onClick={() => handleDeleteUser(user.id)}
                                                                className="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                                            >
                                                                Excluir
                                                            </button>
                                                        </td>
                                                    </tr>
                                                ))
                                            ) : (
                                                <tr>
                                                    <td colSpan="3" className="border-b p-2 text-center">
                                                        Nenhum usuário encontrado.
                                                    </td>
                                                </tr>
                                            )}

                                        </tbody>

                                    </table>
                                </>
                            )}

                            {selectedTab === 'poltronas' && (
                                <>
                                    <Link
                                        href="/poltronas/create"
                                        className="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition text-sm mb-4 inline-block"
                                    >
                                        Cadastre Poltrona
                                    </Link>
                                    <form action="/export-pdf" method="GET" class="flex items-center space-x-4">
                                        <label for="onibus" class="text-sm text">Escolha o Ônibus:</label>
                                        <select name="onibus" id="onibus" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 bg-white text-gray-800 text-sm">
                                            <option value="Onibus 1">Ônibus 1</option>
                                            <option value="Onibus 2">Ônibus 2</option>
                                        </select>
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition text-sm">
                                            Gerar PDF
                                        </button>
                                    </form>
                                    <h3 className="text-lg font-semibold">Poltronas Cadastradas</h3>

                                    {/* Separando poltronas por ônibus */}
                                    {['Onibus 1', 'Onibus 2'].map((onibus) => (
                                        <div key={onibus} className="mt-6">
                                            <h4 className="text-md font-semibold bg-gray-700 text-white px-4 py-2 rounded-md">
                                                {onibus}
                                            </h4>
                                            <table className="min-w-full mt-4 border-collapse text-gray-300">
                                                <thead>
                                                    <tr>
                                                        <th className="border-b p-2">Número da Poltrona</th>
                                                        <th className="border-b p-2">Usuário Associado</th>
                                                        <th className="border-b p-2">Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {poltronas.filter(p => p.onibus === onibus).length > 0 ? (
                                                        poltronas
                                                            .filter(p => p.onibus === onibus)
                                                            .map((poltrona) => (
                                                                <tr key={poltrona.id}>
                                                                    <td className="border-b p-2">{poltrona.numero}</td>
                                                                    <td className="border-b p-2">
                                                                        {poltrona.usuario ? poltrona.usuario.nome : 'Nenhum usuário associado'}
                                                                    </td>
                                                                    <td className="border-b p-2 text-center">
                                                                        <button
                                                                            onClick={() => handleDeletePoltrona(poltrona.id)}
                                                                            className="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                                                        >
                                                                            Excluir
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            ))
                                                    ) : (
                                                        <tr>
                                                            <td colSpan="3" className="border-b p-2 text-center">
                                                                Nenhuma poltrona cadastrada para {onibus}.
                                                            </td>
                                                        </tr>
                                                    )}
                                                </tbody>
                                            </table>
                                        </div>
                                    ))}
                                </>
                            )}

                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
