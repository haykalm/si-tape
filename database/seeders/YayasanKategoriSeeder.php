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
            'name' => 'yayasan A',
            'kategori_pr_id' => 5
        ]);
        Yayasan::create([
            'name' => 'yayasan B',
            'kategori_pr_id' => 4
        ]);
        Yayasan::create([
            'name' => 'yayasan C',
            'kategori_pr_id' => 3
        ]);
        Yayasan::create([
            'name' => 'yayasan D',
            'kategori_pr_id' => 2
        ]);
        Yayasan::create([
            'name' => 'yayasan E',
            'kategori_pr_id' => 1
        ]);
        Yayasan::create([
            'name' => 'yayasan F',
            'kategori_pr_id' => 1
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
