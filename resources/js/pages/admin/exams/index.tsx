import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface Exam {
    id: number;
    title: string;
    description: string;
    start_time: string;
    end_time: string;
    duration_minutes: number;
    is_active: boolean;
    rooms_count?: number;
    participants_count?: number;
}

interface Props {
    exams: {
        data: Exam[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    [key: string]: unknown;
}

export default function ExamsIndex({ exams }: Props) {
    return (
        <>
            <Head title="Kelola Ujian - Administrator" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-6 dark:from-gray-900 dark:to-gray-800">
                <div className="container mx-auto">
                    <div className="mb-8 flex items-center justify-between">
                        <div>
                            <h1 className="text-4xl font-bold text-gray-900 dark:text-gray-100">
                                📚 Kelola Ujian
                            </h1>
                            <p className="text-xl text-gray-600 dark:text-gray-300">
                                Manajemen ujian kompetensi pegawai
                            </p>
                        </div>
                        <Link href={route('exams.create')}>
                            <Button className="bg-indigo-600 hover:bg-indigo-700">
                                ➕ Buat Ujian Baru
                            </Button>
                        </Link>
                    </div>

                    {/* Stats Cards */}
                    <div className="mb-8 grid gap-6 md:grid-cols-4">
                        <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                            <div className="flex items-center">
                                <div className="text-3xl">📝</div>
                                <div className="ml-4">
                                    <div className="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                        {exams.total}
                                    </div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">
                                        Total Ujian
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                            <div className="flex items-center">
                                <div className="text-3xl">✅</div>
                                <div className="ml-4">
                                    <div className="text-2xl font-bold text-green-600">
                                        {exams.data.filter(e => e.is_active).length}
                                    </div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">
                                        Ujian Aktif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                            <div className="flex items-center">
                                <div className="text-3xl">🏢</div>
                                <div className="ml-4">
                                    <div className="text-2xl font-bold text-blue-600">
                                        {exams.data.reduce((sum, e) => sum + (e.rooms_count || 0), 0)}
                                    </div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">
                                        Total Ruangan
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                            <div className="flex items-center">
                                <div className="text-3xl">👥</div>
                                <div className="ml-4">
                                    <div className="text-2xl font-bold text-purple-600">
                                        {exams.data.reduce((sum, e) => sum + (e.participants_count || 0), 0)}
                                    </div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">
                                        Total Peserta
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Exams List */}
                    <div className="rounded-xl bg-white shadow-lg dark:bg-gray-800">
                        <div className="border-b p-6 dark:border-gray-700">
                            <h2 className="text-xl font-bold text-gray-900 dark:text-gray-100">
                                Daftar Ujian
                            </h2>
                        </div>
                        
                        {exams.data.length === 0 ? (
                            <div className="p-12 text-center">
                                <div className="text-6xl">📭</div>
                                <h3 className="mt-4 text-xl font-bold text-gray-900 dark:text-gray-100">
                                    Belum Ada Ujian
                                </h3>
                                <p className="mt-2 text-gray-600 dark:text-gray-400">
                                    Mulai dengan membuat ujian pertama Anda.
                                </p>
                                <Link href={route('exams.create')} className="mt-4 inline-block">
                                    <Button className="bg-indigo-600 hover:bg-indigo-700">
                                        ➕ Buat Ujian Pertama
                                    </Button>
                                </Link>
                            </div>
                        ) : (
                            <div className="divide-y dark:divide-gray-700">
                                {exams.data.map((exam) => (
                                    <div key={exam.id} className="p-6">
                                        <div className="flex items-start justify-between">
                                            <div className="flex-1">
                                                <div className="flex items-center gap-3">
                                                    <h3 className="text-lg font-bold text-gray-900 dark:text-gray-100">
                                                        {exam.title}
                                                    </h3>
                                                    <span className={`rounded-full px-2 py-1 text-xs font-medium ${
                                                        exam.is_active 
                                                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                            : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
                                                    }`}>
                                                        {exam.is_active ? '✅ Aktif' : '⏸️ Nonaktif'}
                                                    </span>
                                                </div>
                                                
                                                <p className="mt-2 text-gray-600 dark:text-gray-400">
                                                    {exam.description}
                                                </p>
                                                
                                                <div className="mt-3 flex gap-6 text-sm text-gray-500 dark:text-gray-400">
                                                    <div className="flex items-center gap-1">
                                                        <span>📅</span>
                                                        <span>
                                                            {new Date(exam.start_time).toLocaleDateString('id-ID', {
                                                                day: 'numeric',
                                                                month: 'short',
                                                                year: 'numeric'
                                                            })}
                                                        </span>
                                                    </div>
                                                    <div className="flex items-center gap-1">
                                                        <span>⏱️</span>
                                                        <span>{exam.duration_minutes} menit</span>
                                                    </div>
                                                    <div className="flex items-center gap-1">
                                                        <span>🏢</span>
                                                        <span>{exam.rooms_count || 0} ruangan</span>
                                                    </div>
                                                    <div className="flex items-center gap-1">
                                                        <span>👥</span>
                                                        <span>{exam.participants_count || 0} peserta</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div className="ml-6 flex gap-2">
                                                <Link href={route('exams.show', exam.id)}>
                                                    <Button variant="outline" size="sm">
                                                        👁️ Detail
                                                    </Button>
                                                </Link>
                                                <Link href={route('exams.edit', exam.id)}>
                                                    <Button variant="outline" size="sm">
                                                        ✏️ Edit
                                                    </Button>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>

                    {/* Pagination */}
                    {exams.last_page > 1 && (
                        <div className="mt-6 flex items-center justify-between">
                            <div className="text-sm text-gray-600 dark:text-gray-400">
                                Menampilkan {((exams.current_page - 1) * exams.per_page) + 1} - {Math.min(exams.current_page * exams.per_page, exams.total)} dari {exams.total} ujian
                            </div>
                            <div className="flex gap-2">
                                {exams.current_page > 1 && (
                                    <Button variant="outline" size="sm">
                                        ← Sebelumnya
                                    </Button>
                                )}
                                {exams.current_page < exams.last_page && (
                                    <Button variant="outline" size="sm">
                                        Selanjutnya →
                                    </Button>
                                )}
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}