<?php

namespace Database\Seeders;

use App\Models\Aspek;
use App\Models\Indikator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AspekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aspeks = [
            (Object) [
                'nama' => 'Keselamatan',
                'sub' => '',
                'color' => '',
                'indikator' => [
                    'Atap',
                    'Plafon',
                    'Dinding',
                ]
            ],

            (Object) [
                'nama' => 'Keindahan',
                'sub' => '',
                'color' => '',
                'indikator' => [
                    'Fasade Bangunan',
                    'Signage',
                    'Lantai',
                ]
            ],

            (Object) [
                'nama' => 'Kesehatan',
                'sub' => '',
                'color' => '',
                'indikator' => [
                    'Pencahayaan',
                    'Penghawaan',
                ]
            ],

            (Object) [
                'nama' => 'Kenyamanan',
                'sub' => 'Pelayanan Pengunjung',
                'color' => '',
                'indikator' => [
                    'Ruang dan Meja Pelayanan',
                    'Area Tunggu',
                    'Backdrop',
                    'Display UMKM',
                ]
            ],

            (Object) [
                'nama' => 'Kenyamanan',
                'sub' => 'Fasilitas Petugas',
                'color' => '',
                'indikator' => [
                    'Ruang Pimpinan',
                    'Ruang Staff',
                    'Ruang Rapat',
                    'Area Parkir',
                ]
            ],

            (Object) [
                'nama' => 'Sanitasi',
                'sub' => '',
                'color' => '',
                'indikator' => [
                    'Drainase',
                    'Kamar Mandi Pengunjung',
                    'Kamar Mandi Petugas',
                ]
            ],
        ];

        foreach($aspeks as $_a => $a) {
            $aspek = new Aspek();
            $aspek->nama_aspek = $a->nama;
            $aspek->sub_aspek = $a->sub;
            $aspek->save();

            foreach($a->indikator as $_i => $i) {
                $indikator = new Indikator();
                $indikator->id_aspek = $aspek->id;
                $indikator->nama_indikator = $i;
                $indikator->save();
            }
        }
    }
}
