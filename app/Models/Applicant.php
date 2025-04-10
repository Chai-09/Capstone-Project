<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'applicant_fname', 'applicant_mname', 'applicant_lname', 'current_school', 'incoming_grlvl',
    ];

    // An applicant belongs to a guardian
    public function guardians()
    {
        return $this->belongsTo(Guardians::class);
    }
}
