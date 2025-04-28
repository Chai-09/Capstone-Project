<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        //applicant id
        'applicant_id',
    ];
    public $timestamps = false;

    public function account()
    {
        return $this->belongsTo(Accounts::class);
    }
}
