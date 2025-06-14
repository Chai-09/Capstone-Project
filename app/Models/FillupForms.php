<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FillupForms extends Model
{
    protected $table = 'form_submissions'; //changed form forms to forms submissions
    public $timestamps = true; //added this to make sure it doesnt expect update and created at
    protected $fillable = [
        //applicant
        'applicant_fname',
        'applicant_mname',
        'applicant_lname',
        'applicant_contact_number',
        'applicant_email',
        'region',
        'province',
        'city',
        'barangay',
        'numstreet',
        'postal_code',
        'age',
        'gender',
        'nationality',

        //guardian
        'guardian_fname',
        'guardian_mname',
        'guardian_lname',
        'guardian_contact_number',
        'guardian_email',
        'relation',

        //school information
        'current_school',
        'current_school_city',
        'school_type',
        'educational_level',
        'incoming_grlvl',
        'applicant_bday',
        'lrn_no',
        'strand',
        'source',

        //applicant id
        'applicant_id',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

    public function payment()
{
    return $this->hasOne(\App\Models\Payment::class, 'applicant_id', 'applicant_id');
}

public function schedule()
{
    return $this->hasOne(\App\Models\ApplicantSchedule::class, 'applicant_id', 'applicant_id');
}

}
