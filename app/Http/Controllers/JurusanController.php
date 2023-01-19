<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurusanController extends Controller
{
    public function all()
    {
        $jurusans = DB::select('SELECT * FROM jurusans');
        foreach ($jurusans as $jurusan) {
            echo "$jurusan->id | $jurusan->nama | $jurusan->kepala_jurusan | $jurusan->daya_tampung <br>";
        }
    }

    public function gabung()
    {
        $jurusans = DB::select('SELECT
             jurusans.nama as nama_jurusan,
             mahasiswas.id as id_mahasiswa ,
             mahasiswas.nama as nama_mahasiswa
             FROM jurusans JOIN mahasiswas
             WHERE jurusans.id = mahasiswas.jurusan_id
             ORDER BY jurusans.nama asc');

        foreach ($jurusans as $jurusan) {
            echo "$jurusan->nama_jurusan | $jurusan->id_mahasiswa | $jurusan->nama_mahasiswa <br>";
        }
    }

    public function find(){
        $jurusan = Jurusan::find(2);
//        dump($jurusan->mahasiswas->toArray());
        echo "$jurusan->id | $jurusan->nama | $jurusan->kepala_jurusan | $jurusan->daya_tampung <br>";

        echo "<hr>";

        foreach ($jurusan->mahasiswas as $mahasiswa) {
            echo "$mahasiswa->id | $mahasiswa->nama | $mahasiswa->nim <br>";
        }
    }

    public function where(){
        $jurusan = Jurusan::where('kepala_jurusan', 'like', '%safir%')->first();

        echo "$jurusan->id | $jurusan->nama | $jurusan->kepala_jurusan | $jurusan->daya_tampung <br>";

        echo "Daftar Mahasiswa" ;
        echo "<hr>";
        foreach ($jurusan->mahasiswas as $mahasiswa) {
            echo "$mahasiswa->id | $mahasiswa->nama | $mahasiswa->nim <br>";
        }
    }

    public function allJoin(){
//        $jurusans = Jurusan::all();
        $jurusans = Jurusan::with('mahasiswas')->get();

        foreach ($jurusans as $jurusan) {
            echo "$jurusan->id | $jurusan->nama | $jurusan->kepala_jurusan | $jurusan->daya_tampung <br><br>";
            echo "Daftar Mahasiswa" ;
            echo "<hr>";
            foreach ($jurusan->mahasiswas as $mahasiswa) {
                echo "$mahasiswa->id | $mahasiswa->nama | $mahasiswa->nim <br>";
            }
            echo "<hr>";
        }
    }

    public function has() {
        $jurusans = Jurusan::has('mahasiswas')->get();
        foreach ($jurusans as $jurusan) {
            echo "$jurusan->id | $jurusan->nama | $jurusan->kepala_jurusan | $jurusan->daya_tampung <br><br>";
            echo "Daftar Mahasiswa" ;
            echo "<hr>";
            foreach ($jurusan->mahasiswas as $mahasiswa) {
                echo "$mahasiswa->id | $mahasiswa->nama | $mahasiswa->nim <br>";
            }
            echo "<hr>";
        }
    }

    public function whereHas(){
        $jurusans = Jurusan::whereHas('mahasiswas', function ($query){
            $query->where('nama', 'like', '%padma%');
        })->get();

        foreach ($jurusans as $jurusan) {
            echo "$jurusan->nama <br>";
        }
    }

    public function doesntHave(){
        $jurusans = Jurusan::doesntHave('mahasiswas')->get();
        foreach ($jurusans as $jurusan) {
            echo "$jurusan->nama <br>";
        }
    }

    public function loadCount(){
    $jurusans = Jurusan::where('kepala_jurusan', 'like', '%safir%')->first();
    $jurusans->loadCount('mahasiswas');
    echo "$jurusans->nama ($jurusans->mahasiswas_count) <br>";
    }

    public function insertSave(){

        // tanpa protected guarded di model Jurusan dan mahasiswa
        $jurusan = new Jurusan();
        $jurusan->nama = 'Teknik Geodesi';
        $jurusan->kepala_jurusan = 'Bams';
        $jurusan->daya_tampung = 100;
        $jurusan->save();

//        $jurusan->mahasiswas()->create([
//            'nama' => 'Namiya',
//            'nim' => '1234567890'
//        ]);

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nama = 'Namiya';
        $mahasiswa->nim = '1234567890';

        $jurusan->mahasiswas()->save($mahasiswa);

        echo "Data berhasil disimpan";
    }

    public function insertCreate(){
        $jurusan = Jurusan::where('nama', 'like', '%Teknik Geodesi%')->first();

        $jurusan->mahasiswas()->create([
            'nama' => 'Ella',
            'nim' => '123ddadad'
        ]);

        echo "Data berhasil disimpan";
    }

    public function insertCreateMany(){
        $jurusan = Jurusan::where('nama', 'like', '%Teknik Geodesi%')->first();

        $jurusan->mahasiswas()->createMany([
            [
                'nama' => 'Madun',
                'nim' => '16s7890'
            ],
            [
                'nama' => 'Madam',
                'nim' => '1a567890'
            ]
        ]);

        echo "Data berhasil disimpan";
    }

    public function update(){
        $jurusan_old = Jurusan::where('nama', 'like', '%Teknik Geodesi%')->first();
        $jurusan_new = Jurusan::where('nama', 'like', '%Teknik Mesin%')->first();

        $jurusan_old->mahasiswas()->update([
            'jurusan_id' => $jurusan_new->id
        ]);

        echo "Semua mahasiswa jurusan $jurusan_old->nama berhasil dipindahkan ke jurusan $jurusan_new->nama";
    }

    // cara update ke3 menggunakan method push()

    public function updatePush(){
        $jurusanToUpdate = Jurusan::where('nama', 'Teknik Informatika')->first();

        foreach ($jurusanToUpdate->mahasiswas as $mahasiswa) {
            $mahasiswa->nama = $mahasiswa->nama . ' S. Kom';
            $mahasiswa->push();

            echo "berhasil update $mahasiswa->nama menjadi $mahasiswa->nama . ' S.kom'<br>";
        }

    }

    // delete data satu jurusan beserta mahasiswanya
    public function delete(){
        $jurusan = Jurusan::where('nama', 'like', '%Teknik Geodesi%')->firstOrFail();
        $jurusan->delete();

        echo "$jurusan->nama beserta semua mahasiswa berhasil dihapus";
    }
}
