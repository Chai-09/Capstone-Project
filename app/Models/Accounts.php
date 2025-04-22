<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Accounts extends Authenticatable
{

    use Notifiable;

    protected $table ='accounts'; 
    protected $fillable = ['name', 'email', 'password', 'role'];
    public $timestamps = false;

    public function applicant()
    {
        return $this->hasOne(Applicant::class);
    }
}
