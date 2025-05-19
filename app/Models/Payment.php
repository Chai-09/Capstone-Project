<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\FillupForms;


class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment'; // <--- updated table name

    protected $fillable = [
        'applicant_id',
        'applicant_fname',
        'applicant_mname',
        'applicant_lname',
        'applicant_email',
        'applicant_contact_number',
        'guardian_fname',
        'guardian_mname',
        'guardian_lname',
        'incoming_grlvl',
        'payment_method',
        'proof_of_payment',
        'payment_date',
        'payment_time',
        'payment_for',
    ];

    public function formSubmission()
{
    return $this->hasOne(FillupForms::class, 'applicant_id', 'applicant_id');
}

}
