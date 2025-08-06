import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import InputError from '@/components/input-error';

interface LoginFormData {
    participant_number: string;
    token: string;
    [key: string]: string;
}

export default function ParticipantLogin() {
    const { data, setData, post, processing, errors } = useForm<LoginFormData>({
        participant_number: '',
        token: ''
    });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('participant.store'));
    };

    return (
        <>
            <Head title="Login Peserta Ujian" />

            <div className="flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 px-4 dark:from-gray-900 dark:to-gray-800">
                <div className="w-full max-w-md">
                    <div className="rounded-2xl bg-white p-8 shadow-2xl dark:bg-gray-800">
                        {/* Header */}
                        <div className="mb-8 text-center">
                            <div className="mb-4 text-6xl">📝</div>
                            <h1 className="mb-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
                                Login Peserta Ujian
                            </h1>
                            <p className="text-gray-600 dark:text-gray-400">
                                Masukkan nomor peserta dan token dari pengawas
                            </p>
                        </div>

                        {/* Form */}
                        <form onSubmit={submit} className="space-y-6">
                            <div>
                                <label
                                    htmlFor="participant_number"
                                    className="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Nomor Peserta
                                </label>
                                <input
                                    id="participant_number"
                                    type="text"
                                    value={data.participant_number}
                                    onChange={(e) => setData('participant_number', e.target.value)}
                                    className="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 text-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                                    placeholder="Contoh: P001"
                                    autoFocus
                                    required
                                />
                                <InputError message={errors.participant_number} className="mt-2" />
                            </div>

                            <div>
                                <label
                                    htmlFor="token"
                                    className="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Token Ujian
                                </label>
                                <input
                                    id="token"
                                    type="text"
                                    value={data.token}
                                    onChange={(e) => setData('token', e.target.value.toUpperCase())}
                                    className="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 text-center text-xl font-mono uppercase tracking-wider shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                                    placeholder="ABC123"
                                    maxLength={6}
                                    required
                                />
                                <InputError message={errors.token} className="mt-2" />
                                <p className="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    ⏰ Token berubah setiap 15 menit. Minta token terbaru dari pengawas.
                                </p>
                            </div>

                            <Button
                                type="submit"
                                disabled={processing}
                                className="w-full rounded-lg bg-indigo-600 py-3 text-lg font-semibold text-white hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 disabled:opacity-50 dark:bg-indigo-700 dark:hover:bg-indigo-600 dark:focus:ring-indigo-800"
                            >
                                {processing ? (
                                    <span className="flex items-center justify-center gap-2">
                                        <div className="h-5 w-5 animate-spin rounded-full border-2 border-white border-t-transparent"></div>
                                        Memverifikasi...
                                    </span>
                                ) : (
                                    <span className="flex items-center justify-center gap-2">
                                        🚀 Masuk Ujian
                                    </span>
                                )}
                            </Button>
                        </form>

                        {/* Instructions */}
                        <div className="mt-8 rounded-lg bg-blue-50 p-4 dark:bg-blue-900/20">
                            <h3 className="mb-2 font-semibold text-blue-900 dark:text-blue-100">
                                ℹ️ Petunjuk:
                            </h3>
                            <ul className="space-y-1 text-sm text-blue-800 dark:text-blue-200">
                                <li>• Pastikan koneksi internet stabil</li>
                                <li>• Token hanya berlaku 15 menit</li>
                                <li>• Ujian dapat dilanjutkan jika terputus</li>
                                <li>• Hubungi pengawas jika ada kendala</li>
                            </ul>
                        </div>

                        {/* Back to Home */}
                        <div className="mt-6 text-center">
                            <a
                                href={route('welcome')}
                                className="text-sm text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400"
                            >
                                ← Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}