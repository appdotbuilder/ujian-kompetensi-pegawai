<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property int $exam_id
 * @property string $question_text
 * @property string $question_type
 * @property array|null $options
 * @property string $correct_answer
 * @property string|null $image_path
 * @property int $points
 * @property int $order_index
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Exam $exam
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\ExamAnswer[] $answers
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuestionText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuestionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCorrectAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereOrderIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @method static \Database\Factories\QuestionFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'exam_id',
        'question_text',
        'question_type',
        'options',
        'correct_answer',
        'image_path',
        'points',
        'order_index',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'exam_id' => 'integer',
        'options' => 'array',
        'points' => 'integer',
        'order_index' => 'integer',
    ];

    /**
     * Get the exam that owns this question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get the answers for this question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class);
    }
}