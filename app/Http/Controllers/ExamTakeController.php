<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitAnswerRequest;
use App\Models\ExamSession;
use App\Models\ExamAnswer;
use App\Models\Question;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExamTakeController extends Controller
{
    /**
     * Display the exam taking interface.
     */
    public function index()
    {
        $sessionId = session('exam_session_id');
        
        if (!$sessionId) {
            return redirect()->route('participant.login')
                ->withErrors(['session' => 'Please login first to take the exam.']);
        }
        
        $session = ExamSession::with([
            'participant.exam.questions',
            'participant.room',
            'answers'
        ])->find($sessionId);
        
        if (!$session) {
            return redirect()->route('participant.login')
                ->withErrors(['session' => 'Invalid session. Please login again.']);
        }
        
        // Start session if not started
        if ($session->status === 'not_started') {
            $session->update([
                'status' => 'in_progress',
                'started_at' => now()
            ]);
        }
        
        $exam = $session->participant->exam;
        $questions = $exam->questions;
        $answeredQuestions = $session->answers->keyBy('question_id');
        
        // Calculate remaining time
        $endTime = $session->started_at->addMinutes($exam->duration_minutes);
        $remainingTime = max(0, now()->diffInSeconds($endTime, false));
        
        if ($remainingTime <= 0 && $session->status !== 'completed') {
            $this->completeExamSession($session);
            return redirect()->route('exam.completed');
        }
        
        return Inertia::render('participant/exam', [
            'session' => $session,
            'exam' => $exam,
            'questions' => $questions,
            'answers' => $answeredQuestions,
            'remainingTime' => $remainingTime
        ]);
    }

    /**
     * Submit an answer for a question.
     */
    public function store(SubmitAnswerRequest $request)
    {
        $sessionId = session('exam_session_id');
        $session = ExamSession::find($sessionId);
        
        if (!$session || $session->status !== 'in_progress') {
            return back()->withErrors(['session' => 'Invalid or expired session.']);
        }
        
        $questionId = $request->validated()['question_id'];
        $answer = $request->validated()['answer'];
        
        $question = Question::find($questionId);
        if (!$question || $question->exam_id !== $session->participant->exam_id) {
            return back()->withErrors(['question' => 'Invalid question.']);
        }
        
        // Check if answer is correct
        $isCorrect = $answer === $question->correct_answer;
        
        // Create or update answer
        ExamAnswer::updateOrCreate(
            [
                'exam_session_id' => $session->id,
                'question_id' => $questionId
            ],
            [
                'answer' => $answer,
                'is_correct' => $isCorrect
            ]
        );
        
        return back()->with('success', 'Answer saved successfully.');
    }

    /**
     * Complete the exam session.
     */
    public function update(Request $request)
    {
        $sessionId = session('exam_session_id');
        $session = ExamSession::find($sessionId);
        
        if (!$session || $session->status !== 'in_progress') {
            return back()->withErrors(['session' => 'Invalid or expired session.']);
        }
        
        $this->completeExamSession($session);
        
        return redirect()->route('exam.completed');
    }

    /**
     * Show exam completion page.
     */
    public function show()
    {
        $sessionId = session('exam_session_id');
        $session = ExamSession::with(['participant', 'answers'])->find($sessionId);
        
        if (!$session) {
            return redirect()->route('participant.login');
        }
        
        return Inertia::render('participant/completed', [
            'session' => $session
        ]);
    }

    /**
     * Complete the exam session and calculate score.
     *
     * @param \App\Models\ExamSession $session
     * @return void
     */
    protected function completeExamSession(ExamSession $session)
    {
        // Calculate score
        $correctAnswers = $session->answers()->where('is_correct', true)->count();
        $totalQuestions = $session->participant->exam->questions()->count();
        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;
        
        $session->update([
            'status' => 'completed',
            'ended_at' => now(),
            'score' => $score
        ]);
        
        $session->participant->update([
            'status' => 'completed'
        ]);
    }
}