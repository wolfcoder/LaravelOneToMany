<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    // cara insert dengan teknik mass assignment dengan method create() mesti ditambahkan guarded
    protected $guarded = [];

    // belongto jurusans
    public function jurusan(){
//        return $this->belongsTo(Jurusan::class);
        return $this->belongsTo('App\Models\Jurusan');
    }
}
