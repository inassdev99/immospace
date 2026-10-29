import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';

function App() {
    return (
        <main className="flex min-h-screen items-center justify-center bg-stone-100 px-6">
            <div className="text-center">
                <p className="mb-4 text-sm font-semibold uppercase tracking-widest text-emerald-700">
                    Votre agence immobilière
                </p>

                <h1 className="text-5xl font-bold text-stone-900">
                    Bienvenue sur ImmoSpace
                </h1>

                <p className="mt-6 text-lg text-stone-600">
                    Trouvez le bien qui correspond à votre vie.
                </p>
            </div>
        </main>
    );
}

createRoot(document.getElementById('app')).render(<App />);