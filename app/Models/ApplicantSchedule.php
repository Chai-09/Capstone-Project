<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantSchedule extends Model
{
    protected $table = 'applicant_schedules';

    protected $fillable = [
        'user_id',
        'applicant_name',
        'applicant_contact_number',
        'incoming_grade_level',
        'exam_date',
        'start_time',
        'end_time',
    ];
}
