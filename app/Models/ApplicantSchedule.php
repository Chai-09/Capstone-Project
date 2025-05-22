<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantSchedule extends Model
{
    protected $table = 'applicant_schedules';

    protected $fillable = [
        'applicant_id',
        'admission_number',
        'applicant_name',
        'applicant_contact_number',
        'incoming_grade_level',
        'exam_date',
        'start_time',
        'end_time',
        'venue',
    ];

    public function applicant()
{
    return $this->belongsTo(Applicant::class, 'applicant_id');
}

public function examResult()
{
    return $this->hasOne(\App\Models\ExamResult::class, 'applicant_id', 'applicant_id');
}

}
