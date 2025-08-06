<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\ExamParticipant
 *
 * @property int $id
 * @property int $exam_id
 * @property int $exam_room_id
 * @property string $participant_number
 * @property string $name
 * @property string|null $email
 * @property string|null $employee_id
 * @property string $status
 * @property bool $is_present
 * @property \Illuminate\Support\Carbon|null $check_in_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Exam $exam
 * @property \App\Models\ExamRoom $room
 * @property \App\Models\ExamSession|null $session
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant whereExamRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant whereParticipantNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant whereIsPresent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant whereCheckInTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamParticipant whereUpdatedAt($value)
 * @method static \Database\Factories\ExamParticipantFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ExamParticipant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'exam_id',
        'exam_room_id',
        'participant_number',
        'name',
        'email',
        'employee_id',
        'status',
        'is_present',
        'check_in_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'exam_id' => 'integer',
        'exam_room_id' => 'integer',
        'is_present' => 'boolean',
        'check_in_time' => 'datetime',
    ];

    /**
     * Get the exam for this participant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get the room for this participant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(ExamRoom::class, 'exam_room_id');
    }

    /**
     * Get the exam session for this participant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function session(): HasOne
    {
        return $this->hasOne(ExamSession::class);
    }
}