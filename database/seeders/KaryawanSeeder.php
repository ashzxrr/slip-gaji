<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Karyawan;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('karyawan123');

        $data = [
            
            ['nama' => 'Jevi Lestiono', 'nip' => 'LMG-2025-359', 'jabatan' => 'Driver', 'departemen' => 'Support', 'no_whatsapp' => '--'],
            ['nama' => 'Yofi Andreyan Maulana', 'nip' => 'LMG-2024-863', 'jabatan' => 'Security', 'departemen' => 'Support', 'no_whatsapp' => '6285730836725'],
            ['nama' => 'Fabian Etmon', 'nip' => 'LMG-2024-329', 'jabatan' => 'Driver', 'departemen' => 'Support', 'no_whatsapp' => '6281249314543'],
            ['nama' => 'Pramono', 'nip' => 'LMG-2025-383', 'jabatan' => 'Driver', 'departemen' => 'Support', 'no_whatsapp' => '6281230384709'],
            ['nama' => 'Surat', 'nip' => 'LMG-2016-020', 'jabatan' => 'Driver', 'departemen' => 'Support', 'no_whatsapp' => '6288991467248'],
            ['nama' => 'Agung Saputra', 'nip' => 'LMG-2023-607', 'jabatan' => 'Security', 'departemen' => 'Support', 'no_whatsapp' => '6287711026609'],
            ['nama' => 'Cindy Arista Wullandari', 'nip' => 'LMG-2025-140', 'jabatan' => 'Security', 'departemen' => 'Support', 'no_whatsapp' => '6282338779314'],
            ['nama' => 'Nur Arrofatul Fitriyah', 'nip' => 'LMG-2024-902', 'jabatan' => 'Security', 'departemen' => 'Support', 'no_whatsapp' => '6285851078412'],
            ['nama' => 'Riska Oktaviana', 'nip' => 'LMG-2025-272', 'jabatan' => 'Security', 'departemen' => 'Support', 'no_whatsapp' => '6285702420095'],
            ['nama' => 'Bayu Eko Sulaksono', 'nip' => 'LMG-2024-865', 'jabatan' => 'Security', 'departemen' => 'Support', 'no_whatsapp' => '6281252996550'],
            ['nama' => 'Aditya Joko Samudro', 'nip' => 'LMG-2024-864', 'jabatan' => 'Security', 'departemen' => 'Support', 'no_whatsapp' => '6281615909283'],
            ['nama' => 'Muhammad Afandi', 'nip' => 'LMG-2024-866', 'jabatan' => 'Security', 'departemen' => 'Support', 'no_whatsapp' => '6285707202561'],
            ['nama' => 'Fardhind Luthfi Alfirdaus', 'nip' => 'LMG-2024-880', 'jabatan' => 'Security', 'departemen' => 'Support', 'no_whatsapp' => '6285755111660'],
            ['nama' => 'Andrian Felani', 'nip' => 'LMG-2024-881', 'jabatan' => 'Security', 'departemen' => 'Support', 'no_whatsapp' => '6288834584752'],
            ['nama' => 'Siti Maisaroh', 'nip' => 'LMG-2025-608', 'jabatan' => 'Office Girl', 'departemen' => 'Support', 'no_whatsapp' => '6285143991228'],
            ['nama' => 'Ratna Suminar', 'nip' => 'LMG-2025-143', 'jabatan' => 'Staff Finance Accounting', 'departemen' => 'Support', 'no_whatsapp' => '6282310836394'],
            ['nama' => 'Khusnul Fatimah', 'nip' => 'LMG-2024-974', 'jabatan' => 'Staff Payroll', 'departemen' => 'Support', 'no_whatsapp' => '6285812533893'],
            ['nama' => 'Desiana Nur Azizah', 'nip' => 'LMG-2025-068', 'jabatan' => 'Staff Purchasing', 'departemen' => 'Support', 'no_whatsapp' => '6285816640476'],
            ['nama' => 'Kidung Alfiani Sidiq', 'nip' => 'LMG-2024-321', 'jabatan' => 'Staff HR', 'departemen' => 'Support', 'no_whatsapp' => '6285852278638'],
            ['nama' => 'Ahmad Shohazar', 'nip' => 'LMG-2025-371', 'jabatan' => 'Maintenance IT', 'departemen' => 'Support', 'no_whatsapp' => '6283854337646'],
            ['nama' => 'Diwanto', 'nip' => 'LMG-2025-112', 'jabatan' => 'Maintenance', 'departemen' => 'Support', 'no_whatsapp' => '6285646346347'],
            ['nama' => 'Alfian Rudi Iswanto', 'nip' => 'LMG-2024-219', 'jabatan' => 'Maintenance', 'departemen' => 'Support', 'no_whatsapp' => '6285736432176'],
        ];

        foreach ($data as $row) {
            // Skip kalau NIP sudah ada
            if (Karyawan::where('nip', $row['nip'])->exists()) continue;

            Karyawan::create([
                'nama'         => $row['nama'],
                'nip'          => $row['nip'],
                'jabatan'      => $row['jabatan'],
                'departemen'   => $row['departemen'],
                'no_whatsapp'  => $row['no_whatsapp'],
                'username'     => $row['nip'],        // default username = NIP
                'password'     => $password,           // default password = karyawan123
                'aktif'        => true,
                'must_change_password' => true,
            ]);
        }

        $this->command->info('✅ ' . count($data) . ' karyawan berhasil di-seed!');
    }
}