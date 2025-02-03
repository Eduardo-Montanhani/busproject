import { useState, useEffect } from 'react';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Link } from '@inertiajs/react';
import { Head } from '@inertiajs/react';

export default function Dashboard({ users, poltronas }) {
    const [selectedTab, setSelectedTab] = useState('users'); // Estado para controlar a aba selecionada

    // Função para alternar entre as abas e atualizar a URL
    const handleTabClick = (tab) => {
        setSelectedTab(tab);
        const url = tab === 'users' ? '/users' : '/poltronas';
        Inertia.visit(url, { preserveState: false, replace: true }); // Usando replace para garantir que a URL seja atualizada
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
                                                        <td className="border-b p-2">{user.cpf}</td>
                                                    </tr>
                                                ))
                                            ) : (
                                                <tr>
                                                    <td colSpan="2" className="border-b p-2 text-center">
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
                                    <a
                                        href="/export-pdf"
                                        className="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition text-sm"
                                    >
                                        Baixar PDF
                                    </a>


                                    <h3 className="text-lg font-semibold">Poltronas Cadastradas</h3>
                                    <table className="min-w-full mt-4 border-collapse text-gray-300">
                                        <thead>
                                            <tr>
                                                <th className="border-b p-2">Número da Poltrona</th>
                                                <th className="border-b p-2">Usuário Associado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {Array.isArray(poltronas) && poltronas.length > 0 ? (
                                                poltronas.map((poltrona) => (
                                                    <tr key={poltrona.id}>
                                                        <td className="border-b p-2">{poltrona.numero}</td>
                                                        <td className="border-b p-2">
                                                            {poltrona.usuario
                                                                ? poltrona.usuario.nome
                                                                : 'Nenhum usuário associado'}
                                                        </td>
                                                    </tr>
                                                ))
                                            ) : (
                                                <tr>
                                                    <td colSpan="2" className="border-b p-2 text-center">
                                                        Nenhuma poltrona encontrada.
                                                    </td>
                                                </tr>
                                            )}
                                        </tbody>
                                    </table>
                                </>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
