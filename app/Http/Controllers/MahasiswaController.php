<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    // find mahasiswa
    public function find()
    {
        $mahasiswa = Mahasiswa::find(2);
        echo "$mahasiswa->id | $mahasiswa->nama | $mahasiswa->nim | $mahasiswa->jurusan_id <br>";
        echo "Jurusan : $mahasiswa->jurusan->nama <br>";
    }

    // where mahasiswa by name diawali huruf P
    public function where()
    {
        $mahasiswa = Mahasiswa::where('nama', 'like', 'P%')->orderBy('nama', 'desc')->firstOrFail();
        echo "$mahasiswa->id | $mahasiswa->nama | $mahasiswa->nim | $mahasiswa->jurusan_id <br>";
        echo "Jurusan : {$mahasiswa->jurusan->nama} <br>";
    }

    //where chaining return nama jurusan
    public function whereChaining()
    {
        echo $mahasiswa = Mahasiswa::where('nama', 'like', '%Putri%')
            ->where('nim', 'like', '1%') // nim diawali 1
            ->firstOrFail()
            ->jurusan->nama;
    }

    // has mahasiswa
    public function has()
    {
        $mahasiswas = Mahasiswa::has('jurusan')->get();

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nama <br>";
        }
    }

    // mahasiswa whereHas jurusan
    public function whereHas()
    {
        $mahasiswas = Mahasiswa::whereHas('jurusan', function ($query) {
            $query->where('nama', 'like', '%Teknik%');
        })->get();

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nama <br>";
        }
    }

    // mahasiswa yang tidak memiliki jurusan doesntHave

    public function doesntHave()
    {
        $mahasiswas = Mahasiswa::doesntHave('jurusan')->get();

        dump($mahasiswas);
//        foreach ($mahasiswas as $mahasiswa) {
//            echo "$mahasiswa->nama <br>";
//        }
    }

    //input data mahasiswa using associate
    public function associate()
    {
        //where jurusan
        $jurusan = Jurusan::where('nama', 'like', '%sipil%')->first();

        $mahasiswa = new Mahasiswa();
        $mahasiswa->nama = 'Rahmat Edited';
        $mahasiswa->nim = '232323';

        $mahasiswa->jurusan()->associate($jurusan);
        $mahasiswa->save();

        echo "Mahasiswa {$mahasiswa->nama} berhasil disimpan";
    }

    // Update data relationship associate + save
    public function associateUpdate()
    {
        //where jurusan
        $jurusan = Jurusan::where('nama', 'like', '%Sipil%')->first();
        $mahasiswa = Mahasiswa::where('nama', 'like', '%Rahmat%')->first();

        $mahasiswa->jurusan()->associate($jurusan);
        $mahasiswa->save();

        echo "Mahasiswa {$mahasiswa->nama} berhasil diupdate ke jurusan $jurusan->nama";
    }

    // delete data relationship
    public function delete()
    {
        $mahasiswas = Mahasiswa::whereHas('jurusan', function ($query) {
            $query->where('nama', 'like', '%Hukum%');
        })->get();

        foreach ($mahasiswas as $mahasiswa) {
            $mahasiswa->delete();
            $mahasiswa->nama . "Succesfully Deleted";
        }
    }

// memutus hubungan relationship
    public function dissociate()
    {
        $mahasiswas = Mahasiswa::whereHas('jurusan', function ($query) {
            $query->where('nama', 'like', '%Teknik Mesin%');
        })->get();

        foreach ($mahasiswas as $mahasiswa) {
            $mahasiswa->jurusan()->dissociate();
            $mahasiswa->save();
            echo $mahasiswa->nama . "Succesfully Dissociate";
        }
    }

}
