import { useEffect, useState } from "react";

export default function ModalSelect({ isOpen, onSelect, onClose }) {
    const [show, setShow] = useState(isOpen);

    useEffect(() => {
        if (isOpen) {
            setShow(true);
        } else {
            setTimeout(() => setShow(false), 300); // Aguarda a animação antes de remover
        }
    }, [isOpen]);

    if (!show) return null;

    return (
        <div
            className={`fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50
            transition-opacity duration-300 ${isOpen ? "opacity-100" : "opacity-0"}`}
            onClick={onClose} // Fecha ao clicar fora
        >
            <div
                className={`bg-white p-6 rounded-xl shadow-xl w-11/12 max-w-md transform transition-all duration-300
                ${isOpen ? "scale-100 opacity-100" : "scale-90 opacity-0"}`}
                onClick={(e) => e.stopPropagation()} // Impede fechamento ao clicar dentro
            >
                <h2 className="text-2xl font-semibold text-gray-800">Escolha seu tipo de acesso</h2>
                <p className="mt-2 text-gray-600">Selecione uma das opções abaixo:</p>

                <div className="mt-6 flex flex-col gap-4">
                    <button
                        className="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                        onClick={() => onSelect("admin")}
                    >
                        Administrador
                    </button>
                    <button
                        className="w-full px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition"
                        onClick={() => onSelect("aluno")}
                    >
                        Aluno
                    </button>
                </div>
            </div>
        </div>
    );
}
