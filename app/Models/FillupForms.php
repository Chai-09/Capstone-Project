<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FillupForms extends Model
{
    protected $table = 'form_submissions'; //changed form forms to forms submissions
    public $timestamps = false; //added this to make sure it doesnt expect update and created at
    protected $fillable = [
        //applicant
        'applicant_fname',
        'applicant_mname',
        'applicant_lname',
        'applicant_contact_number',
        'applicant_email',
        'numstreet',
        'barangay',
        'cityormunicipality',
        'province',
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
    ];
}
