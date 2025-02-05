import React from 'react';
import { Link } from '@inertiajs/react';

const Welcome = () => {
    return (
        <div className="flex items-center justify-center min-h-screen bg-black">
            <div className="text-center bg-black p-8 rounded-lg shadow-lg">
                <h1 className="text-3xl font-bold text-white mb-4">Bem-vindo à Asseuna</h1>
                <p className="text-white mb-6">Cadastre-se agora para aproveitar todos os recursos.</p>
                <div className="space-y-4">
                    <a
                        href="/usuarios/create"
                        className="px-7 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition block"
                    >
                        Cadastre-se
                    </a>
                    <a
                        href="/usuario/login"
                        className="px-10 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition block"
                    >
                        Login
                    </a>
                </div>

            </div>
        </div>
    );
};

export default Welcome;
