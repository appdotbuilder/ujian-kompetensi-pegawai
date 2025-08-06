import React, { useEffect } from 'react';
import { Head, usePage, router } from '@inertiajs/react';
import { type SharedData } from '@/types';



export default function Dashboard() {
    const { auth } = usePage<SharedData>().props;
    const user = auth.user;

    useEffect(() => {
        if (!user) return;

        // Redirect based on user role
        switch (user.role) {
            case 'administrator':
                router.visit(route('exams.index'));
                break;
            case 'supervisor':
                router.visit(route('supervisor.dashboard'));
                break;
            case 'participant':
                // Keep them on dashboard or redirect to a participant portal
                break;
            default:
                break;
        }
    }, [user]);

    return (
        <>
            <Head title="Dashboard" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
                <div className="container mx-auto px-4 py-8">
                    <div className="mb-8 text-center">
                        <h1 className="mb-4 text-4xl font-bold text-gray-900 dark:text-gray-100">
                            🎯 Dashboard Sistem Ujian
                        </h1>
                        <p className="text-xl text-gray-600 dark:text-gray-300">
                            Selamat datang, {user?.name}
                        </p>
                        <p className="text-lg text-gray-500 dark:text-gray-400">
                            Role: <span className="font-semibold capitalize">{user?.role}</span>
                        </p>
                    </div>

                    {/* Role-based content */}
                    {user?.role === 'administrator' && (
                        <div className="grid gap-6 md:grid-cols-3">
                            <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                <div className="mb-4 text-4xl">📚</div>
                                <h3 className="mb-2 font-bold text-gray-900 dark:text-gray-100">
                                    Kelola Ujian
                                </h3>
                                <p className="mb-4 text-gray-600 dark:text-gray-400">
                                    Buat dan kelola ujian, soal, dan jadwal
                                </p>
                                <a
                                    href={route('exams.index')}
                                    className="inline-block rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                                >
                                    Kelola Ujian
                                </a>
                            </div>

                            <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                <div className="mb-4 text-4xl">📊</div>
                                <h3 className="mb-2 font-bold text-gray-900 dark:text-gray-100">
                                    Laporan & Nilai
                                </h3>
                                <p className="mb-4 text-gray-600 dark:text-gray-400">
                                    Lihat hasil ujian dan statistik
                                </p>
                                <button className="inline-block rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                                    Lihat Laporan
                                </button>
                            </div>

                            <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                <div className="mb-4 text-4xl">🏢</div>
                                <h3 className="mb-2 font-bold text-gray-900 dark:text-gray-100">
                                    Kelola Peserta
                                </h3>
                                <p className="mb-4 text-gray-600 dark:text-gray-400">
                                    Manajemen peserta dan ruang ujian
                                </p>
                                <button className="inline-block rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                                    Kelola Peserta
                                </button>
                            </div>
                        </div>
                    )}

                    {user?.role === 'supervisor' && (
                        <div className="grid gap-6 md:grid-cols-2">
                            <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                <div className="mb-4 text-4xl">🔐</div>
                                <h3 className="mb-2 font-bold text-gray-900 dark:text-gray-100">
                                    Kelola Token
                                </h3>
                                <p className="mb-4 text-gray-600 dark:text-gray-400">
                                    Generate token ujian untuk peserta
                                </p>
                                <a
                                    href={route('supervisor.dashboard')}
                                    className="inline-block rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                                >
                                    Kelola Token
                                </a>
                            </div>

                            <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                <div className="mb-4 text-4xl">📝</div>
                                <h3 className="mb-2 font-bold text-gray-900 dark:text-gray-100">
                                    Berita Acara
                                </h3>
                                <p className="mb-4 text-gray-600 dark:text-gray-400">
                                    Buat dan kelola berita acara ujian
                                </p>
                                <button className="inline-block rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                                    Buat Berita Acara
                                </button>
                            </div>
                        </div>
                    )}

                    {user?.role === 'participant' && (
                        <div className="text-center">
                            <div className="mx-auto max-w-md rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                <div className="mb-4 text-6xl">👨‍💼</div>
                                <h3 className="mb-2 font-bold text-gray-900 dark:text-gray-100">
                                    Portal Peserta
                                </h3>
                                <p className="mb-4 text-gray-600 dark:text-gray-400">
                                    Akses khusus untuk mengikuti ujian
                                </p>
                                <a
                                    href={route('participant.login')}
                                    className="inline-block rounded-lg bg-indigo-600 px-6 py-3 text-white hover:bg-indigo-700"
                                >
                                    Login Ujian
                                </a>
                            </div>
                        </div>
                    )}

                    {/* Quick Stats */}
                    <div className="mt-12 rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                        <h3 className="mb-4 text-xl font-bold text-gray-900 dark:text-gray-100">
                            ℹ️ Informasi Sistem
                        </h3>
                        <div className="grid gap-4 md:grid-cols-4">
                            <div className="text-center">
                                <div className="text-2xl font-bold text-indigo-600">
                                    {user?.role === 'administrator' ? '∞' : '1'}
                                </div>
                                <div className="text-sm text-gray-600 dark:text-gray-400">Akses Level</div>
                            </div>
                            <div className="text-center">
                                <div className="text-2xl font-bold text-green-600">✓</div>
                                <div className="text-sm text-gray-600 dark:text-gray-400">Status Aktif</div>
                            </div>
                            <div className="text-center">
                                <div className="text-2xl font-bold text-blue-600">🔒</div>
                                <div className="text-sm text-gray-600 dark:text-gray-400">Sistem Aman</div>
                            </div>
                            <div className="text-center">
                                <div className="text-2xl font-bold text-purple-600">24/7</div>
                                <div className="text-sm text-gray-600 dark:text-gray-400">Dukungan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}