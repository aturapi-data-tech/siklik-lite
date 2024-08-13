<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterJadwalPoli extends Model
{
    use HasFactory;
    protected $table = 'scmst_scpolis';
    // protected $primaryKey = ['day_id', 'poli_id', 'dr_id'];
    protected $keyType = 'string';
}