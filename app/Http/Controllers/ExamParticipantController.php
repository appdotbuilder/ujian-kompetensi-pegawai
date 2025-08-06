<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginParticipantRequest;
use App\Models\ExamParticipant;
use App\Models\ExamToken;
use App\Models\ExamSession;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ExamParticipantController extends Controller
{
    /**
     * Show the participant login form.
     */
    public function index()
    {
        return Inertia::render('participant/login');
    }

    /**
     * Handle participant login with participant number and token.
     */
    public function store(LoginParticipantRequest $request)
    {
        $participantNumber = $request->validated()['participant_number'];
        $token = $request->validated()['token'];
        
        // Find participant
        $participant = ExamParticipant::where('participant_number', $participantNumber)->first();
        
        if (!$participant) {
            return back()->withErrors(['participant_number' => 'Participant number not found.']);
        }
        
        // Verify token is valid for the participant's room
        $validToken = ExamToken::where('exam_room_id', $participant->exam_room_id)
            ->where('token', $token)
            ->active()
            ->first();
            
        if (!$validToken) {
            return back()->withErrors(['token' => 'Invalid or expired token.']);
        }
        
        // Mark participant as present if not already
        if (!$participant->is_present) {
            $participant->update([
                'is_present' => true,
                'status' => 'present',
                'check_in_time' => now()
            ]);
        }
        
        // Create or resume exam session
        $session = ExamSession::firstOrCreate(
            ['exam_participant_id' => $participant->id],
            [
                'session_token' => Str::random(32),
                'status' => 'not_started'
            ]
        );
        
        // Store session in browser session
        session(['exam_session_id' => $session->id]);
        
        return redirect()->route('exam.take')
            ->with('success', 'Login successful. You can now start your exam.');
    }
}