<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignupOtp extends Model
{
    protected $fillable = ['email', 'otp', 'expires_at'];
    public $timestamps = true;
}
