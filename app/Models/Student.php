<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'nim', 'name', 'email', 'phone', 'birth_date', 'address'
    ];

    protected $casts = [
        'birth_date' => 'date'
    ];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)
            ->withPivot(['exam_scores', 'comments', 'final_score', 'grade'])
            ->withTimestamps();
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function getAverageScore(): float
    {
        $scores = $this->courses()
            ->wherePivotNotNull('final_score')
            ->pluck('final_score');
        
        return $scores->isEmpty() ? 0 : $scores->average();
    }

    public static function calculateGrade(float $score): string
    {
        return match(true) {
            $score >= 85 => 'A',
            $score >= 70 => 'B',
            $score >= 60 => 'C',
            $score >= 50 => 'D',
            default => 'E'
        };
    }
}