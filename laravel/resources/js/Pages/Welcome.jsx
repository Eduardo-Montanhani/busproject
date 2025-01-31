import React from 'react';
import { Link } from '@inertiajs/react';

const Welcome = () => {
  return (
    <div className="flex items-center justify-center min-h-screen bg-black">
      <div className="text-center bg-black p-8 rounded-lg shadow-lg">
        <h1 className="text-3xl font-bold text-white mb-4">Bem-vindo à Asseuna</h1>
        <p className="text-white mb-6">Cadastre-se agora para aproveitar todos os recursos.</p>
        <Link
          href="/usuarios/create"
          className="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
        >
          Cadastre-se
        </Link>
      </div>
    </div>
  );
};

export default Welcome;
