<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CocurricularAchievementsItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cocurricular_achievement_id',
        'achievement',
        'student_count',
    ];

    public function event()
    {
        return $this->belongsTo(CocurricularAchievement::class, 'cocurricular_achievement_id');
    }
}
