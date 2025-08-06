import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="Welcome">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col items-center bg-gradient-to-br from-blue-50 to-indigo-100 p-6 text-gray-900 lg:justify-center lg:p-8 dark:from-gray-900 dark:to-gray-800 dark:text-gray-100">
                <header className="mb-8 w-full max-w-[335px] text-sm lg:max-w-6xl">
                    <nav className="flex items-center justify-end gap-4">
                        {auth.user ? (
                            <Link
                                href={route('dashboard')}
                                className="inline-block rounded-lg border border-indigo-200 bg-indigo-600 px-6 py-2 text-sm font-medium text-white shadow-lg hover:bg-indigo-700 transition-colors dark:border-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-600"
                            >
                                Dashboard
                            </Link>
                        ) : (
                            <>
                                <Link
                                    href={route('login')}
                                    className="inline-block rounded-lg px-5 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors dark:text-gray-300 dark:hover:text-indigo-400"
                                >
                                    Log in
                                </Link>
                                <Link
                                    href={route('register')}
                                    className="inline-block rounded-lg border border-indigo-200 bg-indigo-600 px-6 py-2 text-sm font-medium text-white shadow-lg hover:bg-indigo-700 transition-colors dark:border-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-600"
                                >
                                    Register
                                </Link>
                            </>
                        )}
                    </nav>
                </header>
                <div className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow">
                    <main className="flex w-full max-w-[335px] flex-col lg:max-w-6xl lg:flex-row lg:gap-12">
                        {/* Hero Section */}
                        <div className="flex-1 text-center lg:text-left">
                            <div className="mb-6">
                                <h1 className="mb-4 text-4xl font-bold text-gray-900 lg:text-6xl dark:text-gray-100">
                                    📝 Sistem Ujian Kompetensi
                                </h1>
                                <p className="mb-8 text-xl text-gray-600 lg:text-2xl dark:text-gray-300">
                                    Platform ujian digital yang aman dan mudah digunakan untuk pegawai
                                </p>
                            </div>

                            {/* Key Features */}
                            <div className="mb-12 grid gap-6 lg:grid-cols-2">
                                <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                    <div className="mb-4 text-3xl">👨‍💼</div>
                                    <h3 className="mb-2 font-bold text-gray-900 dark:text-gray-100">
                                        Untuk Peserta Ujian
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Login dengan nomor peserta & token. Ujian dapat dilanjutkan dari PC lain jika terjadi gangguan.
                                    </p>
                                </div>

                                <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                    <div className="mb-4 text-3xl">👮‍♂️</div>
                                    <h3 className="mb-2 font-bold text-gray-900 dark:text-gray-100">
                                        Untuk Pengawas
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Kelola token ujian yang berubah setiap 15 menit. Catat absensi dan buat berita acara.
                                    </p>
                                </div>

                                <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                    <div className="mb-4 text-3xl">⚙️</div>
                                    <h3 className="mb-2 font-bold text-gray-900 dark:text-gray-100">
                                        Untuk Administrator
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Kelola soal ujian, lihat hasil, atur ruang ujian, dan cetak laporan komprehensif.
                                    </p>
                                </div>

                                <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                    <div className="mb-4 text-3xl">🛡️</div>
                                    <h3 className="mb-2 font-bold text-gray-900 dark:text-gray-100">
                                        Keamanan Tinggi
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-400">
                                        Token berubah otomatis, sesi tersimpan aman, dan dukungan recovery jika terputus koneksi.
                                    </p>
                                </div>
                            </div>

                            {/* CTA Section */}
                            <div className="flex flex-col gap-4 sm:flex-row sm:justify-center lg:justify-start">
                                {!auth.user && (
                                    <>
                                        <Link
                                            href={route('login')}
                                            className="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-8 py-3 text-lg font-medium text-white shadow-lg hover:bg-indigo-700 transition-colors dark:bg-indigo-700 dark:hover:bg-indigo-600"
                                        >
                                            🚀 Mulai Sekarang
                                        </Link>
                                        <Link
                                            href={route('participant.login')}
                                            className="inline-flex items-center justify-center rounded-lg border-2 border-indigo-600 px-8 py-3 text-lg font-medium text-indigo-600 hover:bg-indigo-600 hover:text-white transition-colors dark:border-indigo-500 dark:text-indigo-400 dark:hover:bg-indigo-700 dark:hover:text-white"
                                        >
                                            📝 Login Peserta
                                        </Link>
                                    </>
                                )}
                                {auth.user && (
                                    <Link
                                        href={route('dashboard')}
                                        className="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-8 py-3 text-lg font-medium text-white shadow-lg hover:bg-indigo-700 transition-colors dark:bg-indigo-700 dark:hover:bg-indigo-600"
                                    >
                                        📊 Ke Dashboard
                                    </Link>
                                )}
                            </div>
                        </div>

                        {/* Visual Mockup */}
                        <div className="mt-12 flex-1 lg:mt-0">
                            <div className="rounded-2xl bg-white p-8 shadow-2xl dark:bg-gray-800">
                                <div className="mb-6">
                                    <div className="mb-4 h-4 w-3/4 rounded bg-gray-200 dark:bg-gray-600"></div>
                                    <div className="mb-2 h-3 w-1/2 rounded bg-gray-100 dark:bg-gray-700"></div>
                                    <div className="mb-4 h-3 w-2/3 rounded bg-gray-100 dark:bg-gray-700"></div>
                                </div>
                                
                                <div className="mb-6 space-y-3">
                                    <div className="flex items-center gap-3">
                                        <div className="h-4 w-4 rounded-full border-2 border-indigo-500"></div>
                                        <div className="h-3 w-3/4 rounded bg-gray-100 dark:bg-gray-700"></div>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        <div className="h-4 w-4 rounded-full border-2 border-gray-300"></div>
                                        <div className="h-3 w-2/3 rounded bg-gray-100 dark:bg-gray-700"></div>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        <div className="h-4 w-4 rounded-full border-2 border-gray-300"></div>
                                        <div className="h-3 w-1/2 rounded bg-gray-100 dark:bg-gray-700"></div>
                                    </div>
                                </div>

                                <div className="flex gap-3">
                                    <div className="h-10 w-24 rounded-lg bg-indigo-100 dark:bg-indigo-900"></div>
                                    <div className="h-10 w-20 rounded-lg bg-gray-100 dark:bg-gray-700"></div>
                                </div>

                                <div className="mt-6 text-center">
                                    <div className="inline-flex items-center gap-2 rounded-full bg-green-100 px-4 py-2 text-sm font-medium text-green-800 dark:bg-green-900 dark:text-green-200">
                                        ⏱️ Waktu: 45:30
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                
                {/* Footer */}
                <footer className="mt-12 text-center text-sm text-gray-500 dark:text-gray-400">
                    <p className="mb-2">Built with ❤️ by{" "}
                        <a 
                            href="https://app.build" 
                            target="_blank" 
                            className="font-medium text-indigo-600 hover:underline dark:text-indigo-400"
                        >
                            app.build
                        </a>
                    </p>
                    <p>🔒 Sistem ujian yang aman dan terpercaya untuk evaluasi kompetensi pegawai</p>
                </footer>
            </div>
        </>
    );
}