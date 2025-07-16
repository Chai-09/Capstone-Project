<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Accounts extends Authenticatable
{

    use Notifiable, HasApiTokens;

    protected $table ='accounts'; 
    protected $fillable = ['name', 'email', 'password', 'role', 'is_archive'];
    public $timestamps = true;

    public function applicant()
    {
        return $this->hasOne(Applicant::class, 'account_id');
    }

}
