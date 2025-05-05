<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_type',
        'year',
        'gps',
        'certificate_percentage',
    ];

    protected $casts = [
        'year' => 'integer',
        'gps' => 'decimal:2',
        'certificate_percentage' => 'decimal:2',
    ];

    public function grades(): HasMany
    {
        return $this->hasMany(AcademicAchievementGrade::class);
    }
}