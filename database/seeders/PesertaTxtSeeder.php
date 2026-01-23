<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Activity;
use App\Models\Registration;


class PesertaTxtSeeder extends Seeder
{
    public function run()
    {
        $pesertaList = [
            // Data hasil parsing otomatis dari peserta.txt
            [
                'name' => 'Amelia Windasari, S.Pd.,Gr.',
                'email' => 'ameliawindasari65@admin.smk.belajar.id',
                'nik' => '3202164605790007',
                'tempat_lahir' => 'Sukabumi',
                'tanggal_lahir' => '1979-05-06',
                'jenis_kelamin' => 'perempuan',
                'pendidikan_terakhir' => 's1',
                'jurusan' => 'Pendidikan bahasa dan sastra Indonesia',
                'asal_sekolah' => 'SMK Bhakti Kencana Cicurug',
                'npsn' => '69726566',
                'jabatan' => 'kepala sekolah',
                'no_hp' => '082110018932',
                'email_belajar' => 'ameliawindasari65@admin.smk.belajar.id',
                'alamat' => 'Kp. Keboncau RT. 02/02',
            ],
            [
                'name' => 'Siti Syarah Sevia',
                'email' => 'sitisevia10@admin.smk.belajar.id',
                'nik' => '3202287110000003',
                'tempat_lahir' => 'Sukabumi',
                'tanggal_lahir' => '2000-10-31',
                'jenis_kelamin' => 'perempuan',
                'pendidikan_terakhir' => 'smk',
                'jurusan' => 'TKJ',
                'asal_sekolah' => 'SMK Islam Hegarmanah',
                'npsn' => '70004943',
                'jabatan' => 'guru',
                'no_hp' => '085864239873',
                'email_belajar' => 'sitisevia10@admin.smk.belajar.id',
                'alamat' => 'Kp. Cilubang RT 001 RW 010 Desa Hegarmanah Kec. Cicantayan Kab. Sukabumi',
            ],
            [
                'name' => 'Eneng Barokah, S.Pd.I',
                'email' => 'enengbarokah56@guru.smk.belajar.id',
                'nik' => '3202394506830006',
                'tempat_lahir' => 'Sukabumi',
                'tanggal_lahir' => '1983-06-05',
                'jenis_kelamin' => 'perempuan',
                'pendidikan_terakhir' => 's1',
                'jurusan' => 'Pendidikan Agama Islam',
                'asal_sekolah' => 'SMK NURUL HUDA SUKABUMI',
                'npsn' => '69946251',
                'jabatan' => 'guru',
                'no_hp' => '085861318090',
                'email_belajar' => 'enengbarokah56@guru.smk.belajar.id',
                'alamat' => 'Kp. Cikuda Rt/Rw 001/001 Bojongkalong Nyalindung',
            ],
            // ... Seluruh peserta lain hasil parsing peserta.txt ...
        ];

        // Cari activity 'Pelatihan Kurikulum Merdeka' (atau ganti sesuai kebutuhan)
        $activity = Activity::where('name', 'Pelatihan Kurikulum Merdeka')->first();

        foreach ($pesertaList as $peserta) {
            // Cari sekolah berdasarkan npsn
            $sekolah = null;
            if (!empty($peserta['npsn'])) {
                $sekolah = User::where('role', 'sekolah')->where('npsn', $peserta['npsn'])->first();
            }

            $user = User::updateOrCreate(
                [
                    'email' => $peserta['email'],
                ],
                [
                    'name' => $peserta['name'],
                    'email' => $peserta['email'],
                    'email_belajar' => $peserta['email_belajar'] ?? $peserta['email'],
                    'nik' => $peserta['nik'] ?? null,
                    'birth_place' => $peserta['tempat_lahir'] ?? null,
                    'birth_date' => $peserta['tanggal_lahir'] ?? null,
                    'jenis_kelamin' => $peserta['jenis_kelamin'] ?? null,
                    'pendidikan_terakhir' => $peserta['pendidikan_terakhir'] ?? null,
                    'jurusan' => $peserta['jurusan'] ?? null,
                    'institution' => $peserta['asal_sekolah'] ?? null,
                    'npsn' => $peserta['npsn'] ?? null,
                    'jabatan' => $peserta['jabatan'] ?? null,
                    'no_hp' => $peserta['no_hp'] ?? null,
                    'alamat' => $peserta['alamat'] ?? null,
                    'role' => 'peserta',
                    'password' => Hash::make('password123'),
                    // Hubungkan ke sekolah jika ditemukan
                    'instansi' => $sekolah->instansi ?? null,
                    'nama_sekolah' => $sekolah->nama_sekolah ?? $peserta['asal_sekolah'] ?? null,
                    'alamat_sekolah' => $sekolah->alamat_sekolah ?? null,
                ]
            );

            // Daftarkan ke activity jika ada
            if ($activity && $user) {
                Registration::updateOrCreate(
                    [
                        'activity_id' => $activity->id,
                        'user_id' => $user->id,
                    ],
                    [
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->no_hp,
                        'position' => $user->jabatan,
                        'nama_sekolah' => $user->nama_sekolah,
                        'alamat_sekolah' => $user->alamat_sekolah,
                        'status' => 'registered',
                    ]
                );
            }
        }
    }
}
