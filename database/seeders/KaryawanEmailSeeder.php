<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;

class KaryawanEmailSeeder extends Seeder
{
    /**
     * Data email karyawan per Juni 2026 (NIP => Email).
     * Sumber: Email_Karyawan_Bulanan_per_Juni_2026.xlsx
     *
     * Catatan: 2 karyawan tidak punya email di data sumber dan TIDAK
     * termasuk di sini — perlu dilengkapi manual:
     * - Jevi Lestiono (LMG-2025-359, Driver)
     * - Siti Maisaroh (LMG-2025-608, Office Girl)
     */
    public function run(): void
    {
        $data = [
            ['LMG-2025-712', 'edricwijaya@outlook.com'],
            ['LMG-2025-713', 'pj.patrickjustin@gmail.com'],
            ['LMG-2024-190', 'andrianajip123@gmail.com'],
            ['LMG-2018-001', 'novitarosida15@gmail.com'],
            ['LMG-2022-519', 'etikaainur1999@gmail.com'],
            ['LMG-2025-365', 'Khoirulabidin902@gmail.com'],
            ['LMG-2025-151', 'najwaaputri1206@gmail.com'],
            ['LMG-2025-453', 'ainniyah.sh09@gmail.com'],
            ['LMG-2023-751', 'raiharanga774@gmail.com'],
            ['LMG-2017-030', 'suwantosuwanto467@gmail.com'],
            ['LMG-2022-454', 'indarwatiyuni35@gmail.com'],
            ['LMG-2019-069', 'indaahzy@gmail.com'],
            ['LMG-2016-019', 'dwitutik719@gmail.com'],
            ['LMG-2021-147', 'rouf.galor@gmail.com'],
            ['LMG-2016-016', 'zainunur26@gmail.com'],
            ['LMG-2023-569', 'kerinnakerinna5@gmail.com'],
            ['LMG-2024-230', 'liebragirl9@gmail.com'],
            ['LMG-2025-030', 'rethabili672@gmail.com'],
            ['LMG-2024-1004', 'ragilmdn711@gmail.com'],
            ['LMG-2025-454', 'filbelt@yahoo.com'],
            ['LMG-2025-238', 'danyikspi80@gmail.com'],
            ['LMG-2024-1003', 'amoymdn625@gmail.com'],
            ['LMG-2017-028', 'sulaikahmandor01@gmail.com'],
            ['LMG-2015-012', 'afshaquroatulain@gmail.com'],
            ['LMG-2015-001', 'anik71993@gmail.com'],
            ['LMG-2020-105', 'cankiswan@gmail.com'],
            ['LMG-2019-064', 'defani231@gmail.com'],
            ['LMG-2018-047', 'kinarakiara11@gmail.com'],
            ['LMG-2015-015', 'karyabangsa091089@gmail.com'],
            ['LMG-2018-039', 'Muhammadregha1922@gmail.com'],
            ['LMG-2015-005', 'sriu73367@gmail.com'],
            ['LMG-2015-003', 'pbumi569@gmail.com'],
            ['LMG-2019-077', 'wahyusebastian709@gmail.com'],
            ['LMG-2023-016', 'zusitaard@gmail.com'],
            ['LMG-2022-307', 'Puputlalapow@gmail.com'],
            ['LMG-2016-022', 'srivika897@gmail.com'],
            ['LMG-2017-035', 'riadisumberdono@gmail.com'],
            ['LMG-2021-139', 'pakdhekonteng@gmail.com'],
            ['LMG-2018-049', 'dilanrafasyah0@gmail.com'],
            ['LMG-2015-014', 'anitaanitaaaa97@gmail.com'],
            ['LMG-2021-130', 'j4m4ludin14@gmail.com'],
            ['LMG-2022-306', 'muhammadrizkii344@gmail.com'],
            ['LMG-2022-455', 'nikoniki644@gmail.com'],
            ['LMG-2024-1006', 'ilafida98@gmail.com'],
            ['LMG-2022-311', 'prayogaok6@gmail.com'],
            ['LMG-2022-358', 'tsalisakmalulniam@gmail.com'],
            ['LMG-2022-436', 'alim773344@gmail.com'],
            ['LMG-2024-1005', 'Fanigaung6@gmail.com'],
            ['LMG-2024-329', 'fabianetmon94@gmail.com'],
            ['LMG-2025-383', 'rhiyavhitria@gmail.com'],
            ['LMG-2016-020', 'Suratmi29122@gmail.com'],
            ['LMG-2024-219', 'malfianri2006@gmail.com'],
            ['LMG-2025-112', 'Diwanto31@gmail.com'],
            ['LMG-2023-607', 'agungaathee38@gmail.com'],
            ['LMG-2024-881', 'andrian.bcm@gmal.com'],
            ['LMG-2024-865', 'nicky.febryan08@gmail.com'],
            ['LMG-2025-140', 'idaw4723@gmail.com'],
            ['LMG-2024-880', 'versiokky@gmail.com'],
            ['LMG-2024-866', 'muhamadafandi056@gmail.com'],
            ['LMG-2024-902', 'arofatulfitriyah22@gmail.com'],
            ['LMG-2025-272', 'riskapeos@gmail.com'],
            ['LMG-2024-863', 'andreanmaulana794@gmail.com'],
            ['LMG-2025-851', 'Bagussty9@gmail.com'],
            ['LMG-2025-371', 'ahmadshohazar2911@gmail.com'],
            ['LMG-2025-143', 'ratnadyy02@gmail.com'],
            ['LMG-2026-875', 'hikamnaja07@gmail.com'],
            ['LMG-2024-321', 'kidungalf5@gmail.com'],
            ['LMG-2024-974', 'khusnulfatimah359@gmail.com'],
            ['LMG-2025-068', 'desiananurrr11@gmail.com'],
        ];

        $updated = 0;
        $notFound = [];

        foreach ($data as [$nip, $email]) {
            $karyawan = Karyawan::where('nip', $nip)->first();

            if (! $karyawan) {
                $notFound[] = $nip;
                continue;
            }

            $karyawan->update(['email' => $email]);
            $updated++;
        }

        $this->command->info("Email karyawan berhasil diupdate: {$updated}");

        if (! empty($notFound)) {
            $this->command->warn('NIP tidak ditemukan di tabel karyawan: ' . implode(', ', $notFound));
        }
    }
}
