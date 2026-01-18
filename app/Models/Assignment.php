<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'title',
        'description',
        'file_path',
        'file_name',
        'score'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function hasFile(): bool
    {
        return !empty($this->file_path) && !empty($this->file_name);
    }

    public function getFileUrl(): ?string
    {
        if ($this->hasFile()) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }
}