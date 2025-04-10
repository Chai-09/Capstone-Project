<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignupForms extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'guardian_fname', 'guardian_mname', 'guardian_lname', 'guardian_email', 
        'password', 'repassword', 'applicant_fname', 'applicant_mname', 'applicant_lname', 
        'current_school', 'incoming_grlvl'
    ];
    
}
