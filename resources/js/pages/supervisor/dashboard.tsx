import React from 'react';
import { Head } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface ExamToken {
    id: number;
    token: string;
    valid_from: string;
    valid_until: string;
    is_active: boolean;
}

interface ExamRoom {
    id: number;
    name: string;
    capacity: number;
    location: string;
    exam: {
        id: number;
        title: string;
        start_time: string;
        end_time: string;
        duration_minutes: number;
    };
    participants: Array<{
        id: number;
        name: string;
        participant_number: string;
        is_present: boolean;
        status: string;
    }>;
    tokens: ExamToken[];
}

interface Props {
    rooms: ExamRoom[];
    [key: string]: unknown;
}

export default function SupervisorDashboard({ rooms }: Props) {
    const handleGenerateToken = (roomId: number) => {
        // This will be implemented
        console.log('Generate token for room', roomId);
    };

    return (
        <>
            <Head title="Dashboard Pengawas" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-6 dark:from-gray-900 dark:to-gray-800">
                <div className="container mx-auto">
                    <div className="mb-8 text-center">
                        <h1 className="mb-4 text-4xl font-bold text-gray-900 dark:text-gray-100">
                            👮‍♂️ Dashboard Pengawas
                        </h1>
                        <p className="text-xl text-gray-600 dark:text-gray-300">
                            Kelola token ujian dan monitor peserta
                        </p>
                    </div>

                    {rooms.length === 0 ? (
                        <div className="text-center">
                            <div className="mx-auto max-w-md rounded-xl bg-white p-8 shadow-lg dark:bg-gray-800">
                                <div className="mb-4 text-6xl">📅</div>
                                <h3 className="mb-2 text-xl font-bold text-gray-900 dark:text-gray-100">
                                    Tidak Ada Ujian Aktif
                                </h3>
                                <p className="text-gray-600 dark:text-gray-400">
                                    Belum ada ujian yang dijadwalkan untuk hari ini.
                                </p>
                            </div>
                        </div>
                    ) : (
                        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            {rooms.map((room) => {
                                const currentToken = room.tokens?.[0];
                                const isTokenActive = currentToken?.is_active && 
                                    new Date(currentToken.valid_until) > new Date();
                                
                                return (
                                    <div key={room.id} className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                        <div className="mb-4">
                                            <h3 className="text-xl font-bold text-gray-900 dark:text-gray-100">
                                                {room.name}
                                            </h3>
                                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                                {room.location}
                                            </p>
                                        </div>

                                        <div className="mb-4">
                                            <h4 className="font-semibold text-gray-900 dark:text-gray-100">
                                                {room.exam.title}
                                            </h4>
                                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                                Durasi: {room.exam.duration_minutes} menit
                                            </p>
                                        </div>

                                        <div className="mb-4 rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                                            <div className="flex items-center justify-between">
                                                <span className="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Token Aktif:
                                                </span>
                                                {isTokenActive ? (
                                                    <span className="text-lg font-mono text-green-600 dark:text-green-400">
                                                        {currentToken.token}
                                                    </span>
                                                ) : (
                                                    <span className="text-sm text-red-600 dark:text-red-400">
                                                        Tidak ada token aktif
                                                    </span>
                                                )}
                                            </div>
                                            {isTokenActive && (
                                                <p className="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                    Berlaku hingga: {new Date(currentToken.valid_until).toLocaleTimeString('id-ID')}
                                                </p>
                                            )}
                                        </div>

                                        <div className="mb-4">
                                            <div className="grid grid-cols-2 gap-4 text-center">
                                                <div>
                                                    <div className="text-2xl font-bold text-blue-600">
                                                        {room.participants?.length || 0}
                                                    </div>
                                                    <div className="text-xs text-gray-600 dark:text-gray-400">
                                                        Total Peserta
                                                    </div>
                                                </div>
                                                <div>
                                                    <div className="text-2xl font-bold text-green-600">
                                                        {room.participants?.filter(p => p.is_present)?.length || 0}
                                                    </div>
                                                    <div className="text-xs text-gray-600 dark:text-gray-400">
                                                        Hadir
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div className="space-y-2">
                                            <Button
                                                onClick={() => handleGenerateToken(room.id)}
                                                className="w-full bg-indigo-600 hover:bg-indigo-700"
                                            >
                                                🔑 Generate Token Baru
                                            </Button>
                                            <Button
                                                variant="outline"
                                                className="w-full"
                                                onClick={() => window.open(`/supervisor/room/${room.id}`, '_blank')}
                                            >
                                                👁️ Monitor Ruangan
                                            </Button>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    )}

                    {/* Quick Actions */}
                    <div className="mt-12 rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                        <h3 className="mb-4 text-xl font-bold text-gray-900 dark:text-gray-100">
                            🚀 Aksi Cepat
                        </h3>
                        <div className="grid gap-4 md:grid-cols-3">
                            <Button variant="outline" className="h-20">
                                <div className="text-center">
                                    <div className="text-2xl">📊</div>
                                    <div className="text-sm">Lihat Laporan</div>
                                </div>
                            </Button>
                            <Button variant="outline" className="h-20">
                                <div className="text-center">
                                    <div className="text-2xl">👥</div>
                                    <div className="text-sm">Kelola Absensi</div>
                                </div>
                            </Button>
                            <Button variant="outline" className="h-20">
                                <div className="text-center">
                                    <div className="text-2xl">📝</div>
                                    <div className="text-sm">Berita Acara</div>
                                </div>
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}