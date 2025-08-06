<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ExamRoom
 *
 * @property int $id
 * @property int $exam_id
 * @property string $name
 * @property int $capacity
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Exam $exam
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\ExamParticipant[] $participants
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\ExamToken[] $tokens
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\ExamReport[] $reports
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ExamRoom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamRoom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamRoom query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamRoom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamRoom whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamRoom whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamRoom whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamRoom whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamRoom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamRoom whereUpdatedAt($value)
 * @method static \Database\Factories\ExamRoomFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ExamRoom extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'exam_id',
        'name',
        'capacity',
        'location',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'exam_id' => 'integer',
        'capacity' => 'integer',
    ];

    /**
     * Get the exam that owns this room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get the participants in this room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants(): HasMany
    {
        return $this->hasMany(ExamParticipant::class);
    }

    /**
     * Get the tokens for this room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tokens(): HasMany
    {
        return $this->hasMany(ExamToken::class);
    }

    /**
     * Get the reports for this room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports(): HasMany
    {
        return $this->hasMany(ExamReport::class);
    }
}