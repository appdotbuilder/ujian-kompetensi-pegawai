<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateTokenRequest;
use App\Http\Requests\StoreExamReportRequest;
use App\Models\ExamRoom;
use App\Models\ExamToken;
use App\Models\ExamReport;
use App\Models\ExamParticipant;
use Inertia\Inertia;
use Illuminate\Support\Str;

class SupervisorController extends Controller
{
    /**
     * Display the supervisor dashboard.
     */
    public function index()
    {
        $rooms = ExamRoom::with(['exam', 'participants', 'tokens' => function ($query) {
            $query->where('is_active', true)
                  ->where('valid_from', '<=', now())
                  ->where('valid_until', '>=', now())
                  ->latest();
        }])
        ->whereHas('exam', function ($query) {
            $query->where('start_time', '<=', now())
                  ->where('end_time', '>=', now())
                  ->where('is_active', true);
        })
        ->get();

        return Inertia::render('supervisor/dashboard', [
            'rooms' => $rooms
        ]);
    }

    /**
     * Show room details and manage tokens.
     */
    public function show(ExamRoom $room)
    {
        $room->load([
            'exam',
            'participants',
            'tokens' => function ($query) {
                $query->latest();
            }
        ]);

        $currentToken = $room->tokens()
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->first();

        return Inertia::render('supervisor/room', [
            'room' => $room,
            'currentToken' => $currentToken,
            'participants' => $room->participants,
            'statistics' => [
                'total' => $room->participants->count(),
                'present' => $room->participants->where('is_present', true)->count(),
                'absent' => $room->participants->where('is_present', false)->count(),
                'completed' => $room->participants->where('status', 'completed')->count()
            ]
        ]);
    }

    /**
     * Generate a new token for the room.
     */
    public function store(GenerateTokenRequest $request)
    {
        $roomId = $request->validated()['room_id'];
        $room = ExamRoom::findOrFail($roomId);

        // Deactivate current tokens
        ExamToken::where('exam_room_id', $room->id)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        // Generate new token (6 digit alphanumeric)
        $token = strtoupper(Str::random(6));

        $examToken = ExamToken::create([
            'exam_room_id' => $room->id,
            'token' => $token,
            'valid_from' => now(),
            'valid_until' => now()->addMinutes(15),
            'is_active' => true
        ]);

        return back()->with('success', "New token generated: {$token}");
    }

    /**
     * Update participant attendance.
     */
    public function update(ExamParticipant $participant)
    {
        $participant->update([
            'is_present' => !$participant->is_present,
            'status' => $participant->is_present ? 'registered' : 'present',
            'check_in_time' => $participant->is_present ? null : now()
        ]);

        return back()->with('success', 'Attendance updated successfully.');
    }

    /**
     * Create exam report.
     */
    public function edit(ExamRoom $room)
    {
        $room->load(['participants', 'exam']);
        
        $existingReport = ExamReport::where('exam_room_id', $room->id)
            ->where('supervisor_id', auth()->id())
            ->first();

        return Inertia::render('supervisor/report', [
            'room' => $room,
            'participants' => $room->participants,
            'report' => $existingReport,
            'statistics' => [
                'total' => $room->participants->count(),
                'present' => $room->participants->where('is_present', true)->count(),
                'absent' => $room->participants->where('is_present', false)->count(),
                'completed' => $room->participants->where('status', 'completed')->count()
            ]
        ]);
    }

    /**
     * Store exam report.
     */
    public function destroy(StoreExamReportRequest $request, ExamRoom $room)
    {
        $statistics = [
            'total' => $room->participants->count(),
            'present' => $room->participants->where('is_present', true)->count(),
            'absent' => $room->participants->where('is_present', false)->count(),
            'completed' => $room->participants->where('status', 'completed')->count()
        ];

        ExamReport::updateOrCreate(
            [
                'exam_room_id' => $room->id,
                'supervisor_id' => auth()->id()
            ],
            [
                'attendance_notes' => $request->validated()['attendance_notes'],
                'incident_report' => $request->validated()['incident_report'],
                'statistics' => $statistics,
                'submitted_at' => now()
            ]
        );

        return redirect()->route('supervisor.room', $room)
            ->with('success', 'Exam report submitted successfully.');
    }
}