<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ExamToken
 *
 * @property int $id
 * @property int $exam_room_id
 * @property string $token
 * @property \Illuminate\Support\Carbon $valid_from
 * @property \Illuminate\Support\Carbon $valid_until
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\ExamRoom $room
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ExamToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamToken whereExamRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamToken whereValidFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamToken whereValidUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamToken whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamToken active()

 * 
 * @mixin \Eloquent
 */
class ExamToken extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'exam_room_id',
        'token',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'exam_room_id' => 'integer',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the room for this token.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(ExamRoom::class, 'exam_room_id');
    }

    /**
     * Scope a query to only include active tokens.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('valid_from', '<=', now())
                    ->where('valid_until', '>=', now());
    }
}