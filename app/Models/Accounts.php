<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    protected $fillable = ['name', 'email', 'password', 'role'];
    public $timestamps = false;

    public function applicant()
    {
        return $this->hasOne(Applicant::class);
    }
}
