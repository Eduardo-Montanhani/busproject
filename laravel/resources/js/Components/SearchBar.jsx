import { useState } from 'react';

export default function SearchBar({ placeholder, onSearch }) {
    const [query, setQuery] = useState('');

    const handleChange = (event) => {
        setQuery(event.target.value);
        onSearch(event.target.value); // Enviar o valor para o componente pai
    };

    return (
        <input
            type="text"
            value={query}
            onChange={handleChange}
            placeholder={placeholder}
            className="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-gray-800"
        />
    );
}
