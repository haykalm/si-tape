<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Yayasan;
use App\Models\KategoriPR;


class YayasanKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create yayasan
        Yayasan::create([
            'name' => 'AL IHYA',
            'phone' => '085806605068',
            'address' => 'Jl. Keahlian Jaticempaka Pondok Gede ',
            'kategori_pr_id' => 2
        ]);
        Yayasan::create([
            'name' => 'THARIQUL JANNAH',
            'phone' => '083806605069',
            'address' => 'jl. horison i kav pln taman narogong indah, pengasinan, kec. rawalumbu',
            'kategori_pr_id' => 2
        ]);
        Yayasan::create([
            'name' => 'RUMAH SHALOM',
            'phone' => '081806605064',
            'address' => 'jl. bambu kuning selatan rt.004 rw.002 kel. sepanjang jatya, kec. rawalumbu',
            'kategori_pr_id' => 2
        ]);
        Yayasan::create([
            'name' => 'PANTI SINAR PELANGI',
            'phone' => '088806605063',
            'address' => 'jl.kemang sari i no.74 rt.001 rw.11 kel jatibening baru kec. pondok gede',
            'kategori_pr_id' => 2
        ]);
        Yayasan::create([
            'name' => 'KASIH MULIA HAGAINI',
            'phone' => '082806605063',
            'address' => 'jl. harapan indah yh-11 rt.003 rw.030 kel. pejuang kec. medan satria',
            'kategori_pr_id' => 2
        ]);
        Yayasan::create([
            'name' => 'DONGENG CERIA INDONESIA',
            'phone' => '082806605063',
            'address' => 'jl. saleh bawah i/30 rt.005 rw.012, kel.jatimakmur, kec.jatiasih',
            'kategori_pr_id' => 2
        ]);

        // create kategori
        KategoriPR::create([
            'name' => 'odgj'
        ]);
        KategoriPR::create([
            'name' => 'panti asuhan'
        ]);
        KategoriPR::create([
            'name' => 'disabilitas'
        ]);
        KategoriPR::create([
            'name' => 'napi'
        ]);
        KategoriPR::create([
            'name' => 'transgender'
        ]);
    }
}
