<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamSchedule extends Model
{
    use HasFactory;

    protected $table = 'exam_schedules'; // ← Add this line!

    protected $fillable = [
        'exam_date',
        'start_time',
        'end_time',
        'venue',
        'max_participants',
        'educational_level',
    ];

    // In ExamSchedule model
public function applicantSchedules()
{
    return $this->hasMany(ApplicantSchedule::class, 'exam_date', 'exam_date');
}

}
