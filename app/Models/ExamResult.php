<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = [
        'applicant_id',
        'applicant_name',
        'incoming_grade_level',
        'exam_date',
        'exam_status',
        'exam_result',
        'admission_number',
    ];

    public function applicant()
    {
        return $this->belongsTo(\App\Models\Applicant::class);
    }
}
