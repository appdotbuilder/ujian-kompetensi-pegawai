<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ExamSession
 *
 * @property int $id
 * @property int $exam_participant_id
 * @property string $session_token
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $ended_at
 * @property array|null $progress
 * @property float|null $score
 * @property string $status
 * @property string|null $interruption_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\ExamParticipant $participant
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\ExamAnswer[] $answers
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession whereExamParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession whereSessionToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession whereInterruptionReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamSession whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class ExamSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'exam_participant_id',
        'session_token',
        'started_at',
        'ended_at',
        'progress',
        'score',
        'status',
        'interruption_reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'exam_participant_id' => 'integer',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'progress' => 'array',
        'score' => 'decimal:2',
    ];

    /**
     * Get the participant for this session.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(ExamParticipant::class, 'exam_participant_id');
    }

    /**
     * Get the answers for this session.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class);
    }
}