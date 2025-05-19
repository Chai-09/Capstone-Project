<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FillupForms;

class Applicant extends Model
{
    protected $fillable = [
        'account_id',
        'guardian_fname',
        'guardian_mname',
        'guardian_lname',
        'applicant_fname',
        'applicant_mname',
        'applicant_lname',
        'current_school',
        'incoming_grlvl',
        'current_step',
        'applicant_id',
    ];
    public $timestamps = true;

    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_id');
    }

    public function formSubmission()
    {
        return $this->hasOne(FillupForms::class, 'applicant_id', 'id'); //basically para lang maglink yung id ni applicant and sa form_submissions id.
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }
    
    public function schedule() {
        return $this->hasOne(ApplicantSchedule::class);
    }
    
    public function examResult() {
        return $this->hasOne(ExamResult::class);
    }
}
