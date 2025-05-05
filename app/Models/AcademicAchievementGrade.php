<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicAchievementGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_achievement_id',
        'grade',
        'student_count',
    ];

    public function academicAchievement(): BelongsTo
    {
        return $this->belongsTo(AcademicAchievement::class);
    }
}