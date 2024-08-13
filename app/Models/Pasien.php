<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $table = 'rsmst_pasiens';
    protected $primaryKey = 'reg_no';
    protected $keyType = 'string';
    protected $hidden = ['reg_no'];
}