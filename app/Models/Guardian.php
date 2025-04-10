<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{ 
    use HasFactory;
    //protected $table = 'guardians';
    public $timestamps = false;

    protected $fillable = [
        'guardian_fname', 'guardian_mname', 'guardian_lname', 'guardian_email', 'password',
    ];

    
    // A guardian can have many applicants
    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }
}

