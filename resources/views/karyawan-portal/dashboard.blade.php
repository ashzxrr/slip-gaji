@extends('karyawan-portal.layouts.app')
@section('title', 'Slip Gaji Saya')

@section('content')
{{-- Desktop Table View --}}
<div class="hidden md:block bg-white rounded-xl border border-amber-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-amber-50 text-amber-700 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Periode</th>
                <th class="px-4 py-3 text-right">Total Penghasilan</th>
                <th class="px-4 py-3 text-right">Total Potongan</th>
                <th class="px-4 py-3 text-right">Gaji Diterima</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-amber-100">
            @forelse($slips as $slip)
            <tr class="hover:bg-amber-50 transition">
                <td class="px-4 py-3 font-medium text-gray-800">
                    {{ $slip->periode->bulan }} {{ $slip->periode->tahun }}
                </td>
                <td class="px-4 py-3 text-right text-gray-700">
                    Rp {{ number_format($slip->total_penghasilan, 0, ',', '.') }}
                </td>
                <td class="px-4 py-3 text-right text-red-600">
                    Rp {{ number_format($slip->total_potongan, 0, ',', '.') }}
                </td>
                <td class="px-4 py-3 text-right font-semibold text-amber-700">
                    Rp {{ number_format($slip->gaji_diterima, 0, ',', '.') }}
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <button data-slip-id="{{ $slip->id }}" data-slip='{{ json_encode(["periode_bulan" => $slip->periode->bulan, "periode_tahun" => $slip->periode->tahun, "nama" => $slip->karyawan->nama, "nip" => $slip->karyawan->nip, "jabatan" => $slip->karyawan->jabatan, "departemen" => $slip->karyawan->departemen, "gaji_pokok" => $slip->gaji_pokok, "tunjangan_jabatan" => $slip->tunj_jabatan, "tunjangan_masa_kerja" => $slip->tunj_masa_kerja, "tunjangan_komunikasi" => $slip->tunj_komunikasi, "tunjangan_transportasi" => $slip->tunj_transportasi, "tunjangan_performance" => $slip->tunj_performance, "tunjangan_tambahan" => $slip->tunj_tambahan, "overtime" => $slip->overtime, "total_penghasilan" => $slip->total_penghasilan, "pph_21" => $slip->pph21, "bpjs_kesehatan" => $slip->bpjs_kesehatan, "bpjs_ketenagakerjaan" => $slip->bpjs_ketenagakerjaan, "potongan_lain" => $slip->potongan_lain, "pinjaman" => $slip->pinjaman, "total_potongan" => $slip->total_potongan, "gaji_diterima" => $slip->gaji_diterima], JSON_HEX_APOS|JSON_HEX_QUOT) }}' onclick="openPreview(this)" class="text-amber-600 text-xs px-3 py-1.5 border border-amber-300 bg-amber-50 hover:bg-amber-100 rounded-lg transition-all inline-flex items-center gap-1">
                            <i class="fa fa-eye"></i> Lihat
                        </button>
                        <a href="{{ route('portal.slip.download', $slip) }}"
                           target="_blank"
                           class="bg-gradient-to-r from-amber-500 to-amber-600 text-white text-xs px-3 py-1.5 rounded-lg hover:from-amber-600 hover:to-amber-700 shadow-sm transition-all inline-flex items-center gap-1">
                            <i class="fa fa-download"></i> Download
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-10 text-gray-400">
                    Belum ada slip gaji tersedia
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Mobile Card View --}}
<div class="md:hidden space-y-4">
    @forelse($slips as $slip)
    <div class="bg-white rounded-xl border border-amber-100 shadow-sm p-4">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-sm font-bold text-gray-800">{{ $slip->periode->bulan }} {{ $slip->periode->tahun }}</p>
                <p class="text-xs text-gray-500 mt-1">Slip Gaji</p>
            </div>
        </div>
        <div class="space-y-2 text-sm mb-4">
            <div class="flex justify-between">
                <span class="text-gray-600">Total Penghasilan</span>
                <span class="font-semibold text-gray-800">Rp {{ number_format($slip->total_penghasilan, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Total Potongan</span>
                <span class="font-semibold text-red-600">Rp {{ number_format($slip->total_potongan, 0, ',', '.') }}</span>
            </div>
            <div class="border-t border-amber-100 pt-2 flex justify-between">
                <span class="text-gray-700 font-medium">Gaji Diterima</span>
                <span class="font-bold text-amber-700">Rp {{ number_format($slip->gaji_diterima, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('portal.slip.show', $slip) }}"
               class="flex-1 text-amber-600 text-xs px-3 py-2 border border-amber-300 bg-amber-50 hover:bg-amber-100 rounded-lg transition-all inline-flex items-center justify-center gap-1">
                <i class="fa fa-eye"></i> Lihat Rincian
            </a>
            <a href="{{ route('portal.slip.download', $slip) }}"
               target="_blank"
               class="flex-1 bg-gradient-to-r from-amber-500 to-amber-600 text-white text-xs px-3 py-2 rounded-lg hover:from-amber-600 hover:to-amber-700 shadow-sm transition-all inline-flex items-center justify-center gap-1">
                <i class="fa fa-download"></i> Download
            </a>
        </div>
    </div>
    @empty
    <div class="text-center py-12 bg-white rounded-xl border border-amber-100">
        <i class="fa fa-inbox text-4xl text-gray-300 mb-3"></i>
        <p class="text-gray-500 text-sm">Belum ada slip gaji tersedia</p>
    </div>
    @endforelse
</div>

{{-- Preview Modal --}}
<div id="previewModal" class="hidden fixed inset-0 bg-black/50 z-60 flex items-center justify-center p-4 md:p-0 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-2xl w-full md:max-w-2xl my-8 md:my-0 border border-amber-100">
        {{-- Modal Header --}}
        <div class="bg-gradient-to-r from-amber-600 to-amber-400 text-white p-6 rounded-t-2xl">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-sm font-semibold text-amber-100 mb-1">PT Walet Abdillah Jabli</h2>
                    <h1 class="text-2xl font-bold">Slip Gaji</h1>
                    <p class="text-amber-100 text-sm mt-1">Periode: <span id="previewPeriode"></span></p>
                </div>
                <button onclick="closePreview()" class="text-white hover:text-amber-100 text-2xl">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>

        {{-- Modal Body --}}
        <div class="p-6 md:p-8 max-h-[70vh] overflow-y-auto">
            {{-- Employee Info --}}
            <div class="bg-amber-50 border border-amber-100 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600 text-xs">Nama</p>
                        <p class="font-semibold text-gray-800" id="previewNama"></p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs">NIP</p>
                        <p class="font-semibold text-gray-800" id="previewNip"></p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs">Jabatan</p>
                        <p class="font-semibold text-gray-800" id="previewJabatan"></p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs">Departemen</p>
                        <p class="font-semibold text-gray-800" id="previewDepartemen"></p>
                    </div>
                </div>
            </div>

            {{-- Income Section --}}
            <div class="mb-6">
                <h3 class="text-sm font-bold text-amber-700 mb-3 pb-2 border-b border-amber-200">RINCIAN PENGHASILAN</h3>
                <table class="w-full text-sm mb-2">
                    <tbody class="space-y-1">
                        <tr class="flex justify-between">
                            <td class="text-gray-600">Gaji Pokok</td>
                            <td class="text-gray-800 font-medium text-right" id="previewGajiPokok"></td>
                        </tr>
                        <tr class="flex justify-between">
                            <td class="text-gray-600">Tunjangan Jabatan</td>
                            <td class="text-gray-800 font-medium text-right" id="previewTunjanganJabatan"></td>
                        </tr>
                        <tr class="flex justify-between">
                            <td class="text-gray-600">Tunjangan Masa Kerja</td>
                            <td class="text-gray-800 font-medium text-right" id="previewTunjanganMasaKerja"></td>
                        </tr>
                        <tr class="flex justify-between">
                            <td class="text-gray-600">Tunjangan Komunikasi</td>
                            <td class="text-gray-800 font-medium text-right" id="previewTunjanganKomunikasi"></td>
                        </tr>
                        <tr class="flex justify-between">
                            <td class="text-gray-600">Tunjangan Transportasi</td>
                            <td class="text-gray-800 font-medium text-right" id="previewTunjanganTransportasi"></td>
                        </tr>
                        <tr class="flex justify-between">
                            <td class="text-gray-600">Tunjangan Performance</td>
                            <td class="text-gray-800 font-medium text-right" id="previewTunjanganPerformance"></td>
                        </tr>
                        <tr class="flex justify-between">
                            <td class="text-gray-600">Tunjangan Tambahan</td>
                            <td class="text-gray-800 font-medium text-right" id="previewTunjanganTambahan"></td>
                        </tr>
                        <tr class="flex justify-between">
                            <td class="text-gray-600">Overtime</td>
                            <td class="text-gray-800 font-medium text-right" id="previewOvertime"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="bg-amber-50 border border-amber-200 rounded p-3 flex justify-between">
                    <span class="font-bold text-amber-800">TOTAL PENGHASILAN</span>
                    <span class="font-bold text-amber-800 text-right" id="previewTotalPenghasilan"></span>
                </div>
            </div>

            {{-- Deduction Section --}}
            <div class="mb-6">
                <h3 class="text-sm font-bold text-red-700 mb-3 pb-2 border-b border-red-200">RINCIAN POTONGAN</h3>
                <table class="w-full text-sm mb-2">
                    <tbody class="space-y-1">
                        <tr class="flex justify-between">
                            <td class="text-gray-600">PPH 21</td>
                            <td class="text-gray-800 font-medium text-right" id="previewPph21"></td>
                        </tr>
                        <tr class="flex justify-between">
                            <td class="text-gray-600">BPJS Kesehatan</td>
                            <td class="text-gray-800 font-medium text-right" id="previewBpjsKesehatan"></td>
                        </tr>
                        <tr class="flex justify-between">
                            <td class="text-gray-600">BPJS Ketenagakerjaan</td>
                            <td class="text-gray-800 font-medium text-right" id="previewBpjsKetenagakerjaan"></td>
                        </tr>
                        <tr class="flex justify-between">
                            <td class="text-gray-600">Potongan Lain</td>
                            <td class="text-gray-800 font-medium text-right" id="previewPotonganLain"></td>
                        </tr>
                        <tr class="flex justify-between">
                            <td class="text-gray-600">Pinjaman</td>
                            <td class="text-gray-800 font-medium text-right" id="previewPinjaman"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="bg-red-50 border border-red-200 rounded p-3 flex justify-between">
                    <span class="font-bold text-red-800">TOTAL POTONGAN</span>
                    <span class="font-bold text-red-800 text-right" id="previewTotalPotongan"></span>
                </div>
            </div>

            {{-- Total Salary --}}
            <div class="bg-gradient-to-r from-amber-50 to-amber-100 border-2 border-amber-300 rounded-lg p-4 text-center mb-6">
                <p class="text-gray-600 text-sm mb-1">Gaji Yang Diterima</p>
                <p class="text-2xl md:text-3xl font-bold text-amber-700" id="previewGajiDiterima"></p>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="bg-gray-50 border-t border-amber-100 px-6 py-4 rounded-b-2xl flex gap-3 md:flex-row flex-col-reverse">
            <button onclick="closePreview()" class="flex-1 md:flex-none px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition font-medium text-sm">
                <i class="fa fa-times mr-2"></i> Tutup
            </button>
            <a id="previewDownloadBtn" href="#" target="_blank" class="flex-1 md:flex-none px-6 py-2 bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-lg hover:from-amber-600 hover:to-amber-700 transition font-medium text-sm text-center">
                <i class="fa fa-download mr-2"></i> Download PDF
            </a>
        </div>
    </div>
</div>

<script>
function formatRp(value) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
}

function openPreview(button) {
    const data = JSON.parse(button.dataset.slip);
    const slipId = button.dataset.slipId;

    document.getElementById('previewPeriode').textContent = data.periode_bulan + ' ' + data.periode_tahun;
    document.getElementById('previewNama').textContent = data.nama;
    document.getElementById('previewNip').textContent = data.nip;
    document.getElementById('previewJabatan').textContent = data.jabatan;
    document.getElementById('previewDepartemen').textContent = data.departemen;
    document.getElementById('previewGajiPokok').textContent = formatRp(data.gaji_pokok);
    document.getElementById('previewTunjanganJabatan').textContent = formatRp(data.tunjangan_jabatan);
    document.getElementById('previewTunjanganMasaKerja').textContent = formatRp(data.tunjangan_masa_kerja);
    document.getElementById('previewTunjanganKomunikasi').textContent = formatRp(data.tunjangan_komunikasi);
    document.getElementById('previewTunjanganTransportasi').textContent = formatRp(data.tunjangan_transportasi);
    document.getElementById('previewTunjanganPerformance').textContent = formatRp(data.tunjangan_performance);
    document.getElementById('previewTunjanganTambahan').textContent = formatRp(data.tunjangan_tambahan);
    document.getElementById('previewOvertime').textContent = formatRp(data.overtime);
    document.getElementById('previewTotalPenghasilan').textContent = formatRp(data.total_penghasilan);
    document.getElementById('previewPph21').textContent = formatRp(data.pph_21);
    document.getElementById('previewBpjsKesehatan').textContent = formatRp(data.bpjs_kesehatan);
    document.getElementById('previewBpjsKetenagakerjaan').textContent = formatRp(data.bpjs_ketenagakerjaan);
    document.getElementById('previewPotonganLain').textContent = formatRp(data.potongan_lain);
    document.getElementById('previewPinjaman').textContent = formatRp(data.pinjaman);
    document.getElementById('previewTotalPotongan').textContent = formatRp(data.total_potongan);
    document.getElementById('previewGajiDiterima').textContent = formatRp(data.gaji_diterima);
    document.getElementById('previewDownloadBtn').href = '/portal/slip/' + slipId + '/download';
    document.getElementById('previewModal').classList.remove('hidden');
}

function closePreview() {
    document.getElementById('previewModal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('previewModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePreview();
        }
    });
});
</script>
@endsection