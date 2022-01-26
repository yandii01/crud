<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    protected $fillable = ['name', 'gender', 'no_hp', 'email', 'salary', 'photo_profile'];
}
