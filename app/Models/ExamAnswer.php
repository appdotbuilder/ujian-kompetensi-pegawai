<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ExamAnswer
 *
 * @property int $id
 * @property int $exam_session_id
 * @property int $question_id
 * @property string $answer
 * @property bool $is_correct
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\ExamSession $session
 * @property \App\Models\Question $question
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ExamAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamAnswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamAnswer query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamAnswer whereExamSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamAnswer whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamAnswer whereIsCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamAnswer whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class ExamAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'exam_session_id',
        'question_id',
        'answer',
        'is_correct',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'exam_session_id' => 'integer',
        'question_id' => 'integer',
        'is_correct' => 'boolean',
    ];

    /**
     * Get the session that owns this answer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(ExamSession::class, 'exam_session_id');
    }

    /**
     * Get the question that this answer belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}