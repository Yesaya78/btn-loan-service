<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = ['user_id', 'judul', 'isi_laporan', 'foto', 'status'];
}