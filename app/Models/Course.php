<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'credits',
        'semester',
        'schedule'
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'course_student')
            ->withPivot(['exam_scores', 'comments', 'final_score', 'grade'])
            ->withTimestamps();
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function getAverageScore(): float
    {
        $scores = $this->students()
            ->wherePivotNotNull('final_score')
            ->pluck('final_score');
        
        return $scores->isEmpty() ? 0 : $scores->average();
    }

    public function getPassRate(): float
    {
        $total = $this->students()->wherePivotNotNull('grade')->count();
        if ($total === 0) return 0;

        $passed = $this->students()
            ->wherePivotIn('grade', ['A', 'B', 'C'])
            ->count();
        
        return round(($passed / $total) * 100, 1);
    }
}