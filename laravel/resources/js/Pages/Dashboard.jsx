import { useState, useEffect } from 'react';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Link, Head } from '@inertiajs/react';
import SearchBar from '@/Components/SearchBar';

export default function Dashboard({ users = [], poltronas = [] }) {
    const [selectedTab, setSelectedTab] = useState('users');
    const [searchQuery, setSearchQuery] = useState('');

    const formatCPF = (cpf) => cpf ? cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4') : '';

    useEffect(() => {
        const currentPath = window.location.pathname;
        if (currentPath.includes('/users')) setSelectedTab('users');
        else if (currentPath.includes('/poltronas')) setSelectedTab('poltronas');
    }, []);

    const handleTabClick = (tab) => {
        setSelectedTab(tab);
        Inertia.visit(tab === 'users' ? '/users' : '/poltronas', { preserveState: false, replace: true });
    };

    const handleDelete = (id, type) => {
        if (confirm(`Tem certeza que deseja excluir este ${type}?`)) {
            Inertia.delete(`/${type}/${id}`, {
                onSuccess: () => alert(`${type === 'users' ? 'Usuário' : 'Poltrona'} excluído com sucesso!`),
                onError: () => alert(`Erro ao excluir ${type}.`),
            });
        }
    };

    // Garantindo que users e poltronas são arrays
    const userList = Array.isArray(users) ? users : [];
    const poltronaList = Array.isArray(poltronas) ? poltronas : [];

    // Filtragem segura
    const filteredUsers = userList.filter(user => user.nome?.toLowerCase().includes(searchQuery.toLowerCase()));
    const filteredPoltronas = poltronaList.filter(poltrona =>
        String(poltrona.numero || '').includes(searchQuery) ||
        poltrona.usuario?.nome.toLowerCase().includes(searchQuery.toLowerCase())
    );


    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold text-white">Dashboard</h2>}>
            <Head title="Dashboard" />
            <div className="py-12 bg-gray-900">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-gray-800 shadow-sm sm:rounded-lg">
                        <div className="p-6 text-white">

                            {/* Alternância de abas */}
                            <div className="flex mb-4">
                                <button
                                    onClick={() => handleTabClick('users')}
                                    className={`mr-4 px-4 py-2 text-sm font-semibold rounded-lg ${selectedTab === 'users' ? 'bg-blue-600' : 'bg-gray-700'} hover:bg-blue-700`}
                                >
                                    Usuários
                                </button>
                                <button
                                    onClick={() => handleTabClick('poltronas')}
                                    className={`px-4 py-2 text-sm font-semibold rounded-lg ${selectedTab === 'poltronas' ? 'bg-blue-600' : 'bg-gray-700'} hover:bg-blue-700`}
                                >
                                    Poltronas
                                </button>
                            </div>

                            {/* Barra de Pesquisa */}
                            <SearchBar placeholder="Buscar..." onSearch={setSearchQuery} />

                            {/* Aba Usuários */}
                            {selectedTab === 'users' && (
                                <>
                                    <h3 className="text-lg font-semibold mt-4">Usuários Cadastrados</h3>
                                    <table className="min-w-full mt-4 border-collapse text-gray-300">
                                        <thead>
                                            <tr>
                                                <th className="border-b p-2">Nome</th>
                                                <th className="border-b p-2">CPF</th>
                                                <th className="border-b p-2">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {filteredUsers.length > 0 ? filteredUsers.map(user => (
                                                <tr key={user.id}>
                                                    <td className="border-b p-2">{user.nome}</td>
                                                    <td className="border-b p-2">{formatCPF(user.cpf)}</td>
                                                    <td className="border-b p-2 text-center">
                                                        <button onClick={() => handleDelete(user.id, 'users')} className="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                            Excluir
                                                        </button>
                                                    </td>
                                                </tr>
                                            )) : (
                                                <tr><td colSpan="3" className="border-b p-2 text-center">Nenhum usuário encontrado.</td></tr>
                                            )}
                                        </tbody>
                                    </table>
                                </>
                            )}

                            {/* Aba Poltronas */}
                            {selectedTab === 'poltronas' && (
                                <>
                                    <Link href="/poltronas/create" className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm mb-4 inline-block">
                                        Cadastre Poltrona
                                    </Link>

                                    <form action="/export-pdf" method="GET" className="flex items-center space-x-4">
                                        <label htmlFor="onibus" className="text-sm">Escolha o Ônibus:</label>
                                        <select name="onibus" id="onibus" className="px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-400 bg-white text-gray-800 text-sm">
                                            <option value="Onibus 1">Ônibus 1</option>
                                            <option value="Onibus 2">Ônibus 2</option>
                                        </select>
                                        <button type="submit" className="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                                            Gerar PDF
                                        </button>
                                    </form>

                                    <h3 className="text-lg font-semibold mt-4">Poltronas Cadastradas</h3>
                                    {['Onibus 1', 'Onibus 2'].map(onibus => (
                                        <div key={onibus} className="mt-6">
                                            <h4 className="text-md font-semibold bg-gray-700 px-4 py-2 rounded-md">{onibus}</h4>
                                            <table className="min-w-full mt-4 border-collapse text-gray-300">
                                                <thead>
                                                    <tr>
                                                        <th className="border-b p-2">Número</th>
                                                        <th className="border-b p-2">Usuário</th>
                                                        <th className="border-b p-2">Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {filteredPoltronas.filter(p => p.onibus === onibus).length > 0 ? (
                                                        filteredPoltronas
                                                            .filter(p => p.onibus === onibus)
                                                            .map((poltrona) => (
                                                                <tr key={poltrona.id}>
                                                                    <td className="border-b p-2">{poltrona.numero}</td>
                                                                    <td className="border-b p-2">
                                                                        {poltrona.usuario ? poltrona.usuario.nome : 'Nenhum usuário associado'}
                                                                    </td>
                                                                    <td className="border-b p-2 text-center">
                                                                        <button
                                                                            onClick={() => handleDelete(poltrona.id, 'poltronas')}
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
