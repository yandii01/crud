<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    protected $fillable = ['firstname','lastname','province','city','birth','street','currentposition',
    'no_hp', 'email', 'zipcode','ktpnumber','banknumber', 'ktp_photo'];
}
