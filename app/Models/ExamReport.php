<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ExamReport
 *
 * @property int $id
 * @property int $exam_room_id
 * @property int $supervisor_id
 * @property string|null $attendance_notes
 * @property string|null $incident_report
 * @property array|null $statistics
 * @property \Illuminate\Support\Carbon|null $submitted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\ExamRoom $room
 * @property \App\Models\User $supervisor
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ExamReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamReport whereExamRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamReport whereSupervisorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamReport whereAttendanceNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamReport whereIncidentReport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamReport whereStatistics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamReport whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamReport whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class ExamReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'exam_room_id',
        'supervisor_id',
        'attendance_notes',
        'incident_report',
        'statistics',
        'submitted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'exam_room_id' => 'integer',
        'supervisor_id' => 'integer',
        'statistics' => 'array',
        'submitted_at' => 'datetime',
    ];

    /**
     * Get the room for this report.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(ExamRoom::class, 'exam_room_id');
    }

    /**
     * Get the supervisor who created this report.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}