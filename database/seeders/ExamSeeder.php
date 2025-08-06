<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ExamRoom;
use App\Models\ExamParticipant;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users with different roles
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'role' => 'administrator',
                'employee_id' => 'ADM001',
            ]
        );

        $supervisor = User::firstOrCreate(
            ['email' => 'supervisor@example.com'],
            [
                'name' => 'Pengawas Ujian',
                'password' => bcrypt('password'),
                'role' => 'supervisor',
                'employee_id' => 'SUP001',
            ]
        );

        // Create sample exams
        $exam1 = Exam::create([
            'title' => 'Ujian Kompetensi Teknis IT',
            'description' => 'Ujian untuk menguji kemampuan teknis di bidang teknologi informasi',
            'start_time' => now()->addDay(),
            'end_time' => now()->addDay()->addHours(3),
            'duration_minutes' => 120,
            'is_active' => true,
        ]);

        $exam2 = Exam::create([
            'title' => 'Ujian Kompetensi Manajemen',
            'description' => 'Ujian untuk menguji kemampuan manajerial dan kepemimpinan',
            'start_time' => now()->addDays(2),
            'end_time' => now()->addDays(2)->addHours(2),
            'duration_minutes' => 90,
            'is_active' => true,
        ]);

        // Create exam rooms
        $rooms1 = collect(['Ruang A', 'Ruang B'])->map(function ($name) use ($exam1) {
            return ExamRoom::create([
                'exam_id' => $exam1->id,
                'name' => $name,
                'capacity' => 30,
                'location' => 'Gedung Utama Lantai 2',
            ]);
        });

        $rooms2 = collect(['Ruang C'])->map(function ($name) use ($exam2) {
            return ExamRoom::create([
                'exam_id' => $exam2->id,
                'name' => $name,
                'capacity' => 25,
                'location' => 'Gedung Utama Lantai 3',
            ]);
        });

        // Create participants for exam 1
        foreach ($rooms1 as $index => $room) {
            for ($i = 1; $i <= 15; $i++) {
                $participantNumber = 'P' . str_pad((string)(($index * 15) + $i), 3, '0', STR_PAD_LEFT);
                ExamParticipant::create([
                    'exam_id' => $exam1->id,
                    'exam_room_id' => $room->id,
                    'participant_number' => $participantNumber,
                    'name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'employee_id' => 'EMP' . fake()->unique()->numberBetween(1000, 9999),
                    'status' => 'registered',
                    'is_present' => false,
                ]);
            }
        }

        // Create participants for exam 2
        foreach ($rooms2 as $index => $room) {
            for ($i = 1; $i <= 20; $i++) {
                $participantNumber = 'M' . str_pad((string)$i, 3, '0', STR_PAD_LEFT);
                ExamParticipant::create([
                    'exam_id' => $exam2->id,
                    'exam_room_id' => $room->id,
                    'participant_number' => $participantNumber,
                    'name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'employee_id' => 'EMP' . fake()->unique()->numberBetween(1000, 9999),
                    'status' => 'registered',
                    'is_present' => false,
                ]);
            }
        }

        // Create questions for exam 1 (IT Technical)
        $itQuestions = [
            [
                'question_text' => 'Apa yang dimaksud dengan Object-Oriented Programming (OOP)?',
                'question_type' => 'multiple_choice',
                'options' => [
                    'A' => 'Paradigma pemrograman berdasarkan konsep objek',
                    'B' => 'Paradigma pemrograman berdasarkan fungsi',
                    'C' => 'Paradigma pemrograman berdasarkan prosedur',
                    'D' => 'Paradigma pemrograman berdasarkan logika',
                ],
                'correct_answer' => 'A',
                'points' => 2,
            ],
            [
                'question_text' => 'Database relational menggunakan struktur tabel untuk menyimpan data.',
                'question_type' => 'true_false',
                'options' => null,
                'correct_answer' => 'true',
                'points' => 1,
            ],
            [
                'question_text' => 'Manakah yang merupakan protokol untuk transfer file di internet?',
                'question_type' => 'multiple_choice',
                'options' => [
                    'A' => 'HTTP',
                    'B' => 'FTP',
                    'C' => 'SMTP',
                    'D' => 'POP3',
                ],
                'correct_answer' => 'B',
                'points' => 2,
            ],
            [
                'question_text' => 'HTML adalah bahasa pemrograman.',
                'question_type' => 'true_false',
                'options' => null,
                'correct_answer' => 'false',
                'points' => 1,
            ],
            [
                'question_text' => 'Apa fungsi utama dari sistem operasi?',
                'question_type' => 'multiple_choice',
                'options' => [
                    'A' => 'Menjalankan aplikasi',
                    'B' => 'Mengelola hardware dan software',
                    'C' => 'Menyimpan data',
                    'D' => 'Menghubungkan ke internet',
                ],
                'correct_answer' => 'B',
                'points' => 2,
            ],
        ];

        foreach ($itQuestions as $index => $questionData) {
            Question::create(array_merge($questionData, [
                'exam_id' => $exam1->id,
                'order_index' => $index + 1,
            ]));
        }

        // Create questions for exam 2 (Management)
        $managementQuestions = [
            [
                'question_text' => 'Apa yang dimaksud dengan kepemimpinan transformasional?',
                'question_type' => 'multiple_choice',
                'options' => [
                    'A' => 'Kepemimpinan yang fokus pada perubahan dan inovasi',
                    'B' => 'Kepemimpinan yang fokus pada reward dan punishment',
                    'C' => 'Kepemimpinan yang tidak mengambil keputusan',
                    'D' => 'Kepemimpinan yang otoriter',
                ],
                'correct_answer' => 'A',
                'points' => 3,
            ],
            [
                'question_text' => 'Manajemen yang baik selalu melibatkan perencanaan strategis.',
                'question_type' => 'true_false',
                'options' => null,
                'correct_answer' => 'true',
                'points' => 2,
            ],
            [
                'question_text' => 'Apa yang dimaksud dengan delegasi dalam manajemen?',
                'question_type' => 'multiple_choice',
                'options' => [
                    'A' => 'Mengambil alih semua tugas bawahan',
                    'B' => 'Memberikan wewenang kepada bawahan',
                    'C' => 'Menghindari tanggung jawab',
                    'D' => 'Membuat keputusan sendiri',
                ],
                'correct_answer' => 'B',
                'points' => 2,
            ],
        ];

        foreach ($managementQuestions as $index => $questionData) {
            Question::create(array_merge($questionData, [
                'exam_id' => $exam2->id,
                'order_index' => $index + 1,
            ]));
        }
    }
}