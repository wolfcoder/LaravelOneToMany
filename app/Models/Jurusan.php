<?php

namespace App\Models;

//use App\Http\Controllers\JIlluminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    // cara insert dengan teknik mass assignment dengan method create() mesti ditambahkan guarded
    protected $guarded = [];

    // one to many : hasMany Mahasiswa
    public function mahasiswas()
    {
//        return $this->hasMany(Mahasiswa::class);
//        return $this->hasMany(Mahasiswa::class, 'jurusan_id', 'id');
//        return $this->hasMany(Mahasiswa::class, 'jurusan_id');
        return $this->hasMany('App\Models\Mahasiswa');

    }
}
