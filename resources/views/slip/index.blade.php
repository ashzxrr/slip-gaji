@extends('layouts.app')
@section('title', 'Slip Gaji — ' . $periode->label)

@section('content')
<div class="flex flex-wrap justify-between items-center mb-5 gap-3">
    <div>
        <a href="{{ route('periode.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700">← Periode</a>
        <h2 class="font-bold text-gray-800 text-xl mt-1">{{ $periode->label }}</h2>
    </div>
    <form method="POST" action="{{ route('periode.slip.salin', $periode) }}"
          onsubmit="return confirm('Salin data gaji dari periode sebelumnya? Data yang sudah ada tidak akan tertimpa.')">
        @csrf
        <button data-loading="Menyalin data..." class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-5 py-2 rounded-lg text-sm hover:from-emerald-600 hover:to-emerald-700 flex items-center gap-2 shadow-md transition-all">
            <i class="fa fa-copy"></i> Salin dari Bulan Lalu
        </button>
    </form>
    <form method="POST" action="{{ route('periode.slip.kirimSemua', $periode) }}"
          onsubmit="return confirm('Kirim semua slip ke WhatsApp? Proses ini memakan beberapa menit.')">
        @csrf
        <button data-loading="Mengirim ke WhatsApp..." class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-5 py-2 rounded-lg text-sm hover:from-emerald-600 hover:to-emerald-700 flex items-center gap-2 disabled:opacity-50 shadow-md transition-all"
                {{ $slips->isEmpty() ? 'disabled' : '' }}>
            <i class="fa fa-paper-plane"></i> Kirim Semua ke WA
        </button>
    </form>
</div>

{{-- Stats --}}
<div class="grid grid-cols-4 gap-3 mb-6">
    <div class="bg-white rounded-xl border border-emerald-100 shadow-sm px-4 py-3 text-center">
        <p class="text-2xl font-bold text-gray-700">{{ $stats['total'] }}</p>
        <p class="text-xs text-gray-400 mt-1">Total Slip</p>
    </div>
    <div class="bg-emerald-100 rounded-xl border border-emerald-200 shadow-sm px-4 py-3 text-center">
        <p class="text-2xl font-bold text-emerald-800">{{ $stats['terkirim'] }}</p>
        <p class="text-xs text-gray-400 mt-1">Terkirim</p>
    </div>
    <div class="bg-red-100 rounded-xl border border-red-200 shadow-sm px-4 py-3 text-center">
        <p class="text-2xl font-bold text-red-800">{{ $stats['gagal'] }}</p>
        <p class="text-xs text-gray-400 mt-1">Gagal</p>
    </div>
    <div class="bg-yellow-100 rounded-xl border border-yellow-200 shadow-sm px-4 py-3 text-center">
        <p class="text-2xl font-bold text-yellow-800">{{ $stats['pending'] }}</p>
        <p class="text-xs text-gray-400 mt-1">Pending</p>
    </div>
</div>

{{-- Belum Input --}}
@if($belumInput->count() > 0)
<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
    <p class="text-sm font-semibold text-yellow-800 mb-3">
        <i class="fa fa-exclamation-triangle"></i>
        {{ $belumInput->count() }} karyawan belum diinput gajinya:
    </p>
    <div class="flex flex-wrap gap-2">
        @foreach($belumInput as $k)
        <button onclick="openModal({{ $k->id }}, '{{ $k->nama }}', '{{ $k->jabatan }}', '{{ $k->nip }}')"
                class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 text-xs px-3 py-1.5
                       rounded-full border border-yellow-300 cursor-pointer">
            + {{ $k->nama }}
        </button>
        @endforeach
    </div>
</div>
@endif
{{-- Search Slip --}}
<div class="px-4 py-3 border-b">
    <input type="text" id="searchSlip" placeholder="Cari nama atau NIP..."
           onkeyup="filterSlip()"
           class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-72
                  focus:outline-none focus:ring-2 focus:ring-green-500">
</div>
{{-- Tabel Slip --}}
<div id="tableSkeleton" class="space-y-3 p-4">
    @for($i = 0; $i < 5; $i++)
    <div class="flex gap-4 animate-pulse">
        <div class="h-4 bg-gray-200 rounded w-1/4"></div>
        <div class="h-4 bg-gray-200 rounded w-1/6"></div>
        <div class="h-4 bg-gray-200 rounded w-1/6"></div>
        <div class="h-4 bg-gray-200 rounded w-1/6"></div>
        <div class="h-4 bg-gray-200 rounded flex-1"></div>
    </div>
    @endfor
</div>

<div id="tableContent" style="display:none;">
<div class="bg-white rounded-xl border border-emerald-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-[#f0fdf9] text-emerald-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Karyawan</th>
                <th class="px-4 py-3 text-left">Jabatan</th>
                <th class="px-4 py-3 text-right">Total Penghasilan</th>
                <th class="px-4 py-3 text-right">Total Potongan</th>
                <th class="px-4 py-3 text-right">Gaji Diterima</th>
                <th class="px-4 py-3 text-center">Status WA</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="slipTable" class="divide-y divide-gray-100">
            @forelse($slips as $slip)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <p class="font-medium text-gray-800">{{ $slip->karyawan->nama }}</p>
                    <p class="text-xs text-gray-400">{{ $slip->karyawan->nip }}</p>
                </td>
                <td class="px-4 py-3 text-gray-600">{{ $slip->karyawan->jabatan }}</td>
                <td class="px-4 py-3 text-right text-gray-700">
                    Rp {{ number_format($slip->total_penghasilan, 0, ',', '.') }}
                </td>
                <td class="px-4 py-3 text-right text-red-600">
                    Rp {{ number_format($slip->total_potongan, 0, ',', '.') }}
                </td>
                <td class="px-4 py-3 text-right font-semibold text-green-700">
                    Rp {{ number_format($slip->gaji_diterima, 0, ',', '.') }}
                </td>
                <td class="px-4 py-3 text-center">
                    @if($slip->status_kirim === 'terkirim')
                        <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded-full">✅ Terkirim</span>
                    @elseif($slip->status_kirim === 'gagal')
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">❌ Gagal</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">⏳ Pending</span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <div class="flex justify-center gap-1">
                        <button onclick="openModalEdit({{ $slip->karyawan->id }}, '{{ $slip->karyawan->nama }}', '{{ $slip->karyawan->jabatan }}', '{{ $slip->karyawan->nip }}', {{ $slip->id }})"
                                class="text-emerald-600 text-xs px-2 py-1 border border-emerald-200 rounded hover:bg-emerald-50 shadow-sm transition-colors">
                            Edit
                        </button>
                        <a href="{{ route('periode.slip.preview', [$periode, $slip]) }}"
                           target="_blank"
                           class="text-gray-600 text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-50 shadow-sm transition-colors">
                            PDF
                        </a>
                        <form method="POST"
                              action="{{ route('periode.slip.kirim', [$periode, $slip]) }}"
                              onsubmit="return confirm('Kirim slip ke WA {{ $slip->karyawan->nama }}?')">
                            @csrf
                            <button class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-xs px-2 py-1 rounded hover:from-emerald-600 hover:to-emerald-700 shadow-sm transition-all">
                                <i class="fa fa-whatsapp"></i> Kirim
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-10 text-gray-400">
                    Belum ada slip gaji untuk periode ini
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <script>
    function filterSlip() {
    const keyword = document.getElementById('searchSlip').value.toLowerCase();
    const rows = document.querySelectorAll('#slipTable tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(keyword) ? '' : 'none';
    });
        }
        </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const skeleton = document.getElementById('tableSkeleton');
            const content  = document.getElementById('tableContent');
            if (skeleton && content) {
                skeleton.style.display = 'none';
                content.style.display  = 'block';
            }
        }, 500);
    });
    </script>
</div>
{{-- tutup tableContent --}}
</div>

{{-- MODAL INPUT GAJI — harus di luar tableContent --}}
<div id="modalGaji" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center px-6 py-4 border-b sticky top-0 bg-white z-10">
            <div>
                <h3 class="font-bold text-gray-800" id="modalNama">Input Gaji</h3>
                <p class="text-xs text-gray-400" id="modalInfo"></p>
            </div>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl">
                <i class="fa fa-times"></i>
            </button>
        </div>

        <form id="formGaji" method="POST" action="">
            @csrf
            <div class="px-6 py-4">
                <div class="mb-3">
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                        PENGHASILAN
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-5">
                    @php
                    $penghasilan = [
                        'gaji_pokok'        => 'Gaji Pokok',
                        'tunj_jabatan'      => 'Tunjangan Jabatan',
                        'tunj_masa_kerja'   => 'Tunjangan Masa Kerja',
                        'tunj_komunikasi'   => 'Tunjangan Komunikasi',
                        'tunj_transportasi' => 'Tunjangan Transportasi',
                        'tunj_performance'  => 'Tunjangan Performance',
                        'tunj_tambahan'     => 'Tunjangan Tambahan',
                        'overtime'          => 'Overtime',
                    ];
                    @endphp
                    @foreach($penghasilan as $field => $label)
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">{{ $label }}</label>
                        <div class="flex">
                            <span class="bg-gray-100 border border-r-0 border-gray-300 px-2 py-2 text-xs text-gray-500 rounded-l-lg">Rp</span>
                            <!-- Hidden input yang dikirim ke server -->
                            <input type="hidden" name="{{ $field }}" id="field_{{ $field }}" value="0">

                            <!-- Input yang ditampilkan ke user (formatted) -->
                            <input type="text" id="display_{{ $field }}"
                                class="w-full border border-gray-300 rounded-r-lg px-3 py-2 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="0"
                                inputmode="numeric"
                                autocomplete="off">
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                        POTONGAN
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    @php
                    $potongan = [
                        'pph21'                => 'PPH 21',
                        'bpjs_kesehatan'       => 'BPJS Kesehatan',
                        'bpjs_ketenagakerjaan' => 'BPJS Ketenagakerjaan',
                        'potongan_lain'        => 'Potongan Lain',
                        'pinjaman'             => 'Pinjaman',
                    ];
                    @endphp
                    @foreach($potongan as $field => $label)
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">{{ $label }}</label>
                        <div class="flex">
                            <span class="bg-gray-100 border border-r-0 border-gray-300 px-2 py-2 text-xs text-gray-500 rounded-l-lg">Rp</span>
                            <!-- Hidden input yang dikirim ke server -->
                            <input type="hidden" name="{{ $field }}" id="field_{{ $field }}" value="0">

                            <!-- Input yang ditampilkan ke user (formatted) -->
                            <input type="text" id="display_{{ $field }}"
                                class="w-full border border-gray-300 rounded-r-lg px-3 py-2 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="0"
                                inputmode="numeric"
                                autocomplete="off">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="px-6 py-4 border-t flex justify-end gap-3 sticky bottom-0 bg-white">
                <button type="button" onclick="closeModal()"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                        class="bg-green-700 text-white px-6 py-2 rounded-lg text-sm hover:bg-green-800 font-medium">
                    Simpan Gaji
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const slipData = {
    @foreach($slips as $slip)
    {{ $slip->id }}: {
        gaji_pokok: {{ $slip->gaji_pokok }},
        tunj_jabatan: {{ $slip->tunj_jabatan }},
        tunj_masa_kerja: {{ $slip->tunj_masa_kerja }},
        tunj_komunikasi: {{ $slip->tunj_komunikasi }},
        tunj_transportasi: {{ $slip->tunj_transportasi }},
        tunj_performance: {{ $slip->tunj_performance }},
        tunj_tambahan: {{ $slip->tunj_tambahan }},
        overtime: {{ $slip->overtime }},
        pph21: {{ $slip->pph21 }},
        bpjs_kesehatan: {{ $slip->bpjs_kesehatan }},
        bpjs_ketenagakerjaan: {{ $slip->bpjs_ketenagakerjaan }},
        potongan_lain: {{ $slip->potongan_lain }},
        pinjaman: {{ $slip->pinjaman }},
    },
    @endforeach
};

const periodeId = {{ $periode->id }};

function openModal(karyawanId, nama, jabatan, nip) {
    document.getElementById('modalNama').textContent = 'Input Gaji — ' + nama;
    document.getElementById('modalInfo').textContent = nip + ' · ' + jabatan;
    document.getElementById('formGaji').action = `/periode/${periodeId}/slip/input/${karyawanId}`;
    resetFields();
    showModal();
}

function openModalEdit(karyawanId, nama, jabatan, nip, slipId) {
    document.getElementById('modalNama').textContent = 'Edit Gaji — ' + nama;
    document.getElementById('modalInfo').textContent = nip + ' · ' + jabatan;
    document.getElementById('formGaji').action = `/periode/${periodeId}/slip/input/${karyawanId}`;
    const data = slipData[slipId];
    if (data) {
        populateFields(data);
    }
    showModal();
}

function resetFields() {
    const fields = [
        'gaji_pokok','tunj_jabatan','tunj_masa_kerja','tunj_komunikasi',
        'tunj_transportasi','tunj_performance','tunj_tambahan','overtime',
        'pph21','bpjs_kesehatan','bpjs_ketenagakerjaan','potongan_lain','pinjaman'
    ];
    fields.forEach(f => {
        const el = document.getElementById('field_' + f);
        if (el) el.value = 0;
    });
}

function showModal() {
    const modal = document.getElementById('modalGaji');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('modalGaji');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function filterSlip() {
    const keyword = document.getElementById('searchSlip').value.toLowerCase();
    const rows = document.querySelectorAll('#slipTable tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(keyword) ? '' : 'none';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const skeleton = document.getElementById('tableSkeleton');
        const content  = document.getElementById('tableContent');
        if (skeleton && content) {
            skeleton.style.display = 'none';
            content.style.display  = 'block';
        }
    }, 500);
});
</script>

<script>
// Utility format/unformat rupiah
function formatRupiah(angka) {
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function unformatRupiah(str) {
    return (str || '').toString().replace(/\./g, '') || '0';
}

const rupiahFields = [
    'gaji_pokok', 'tunj_jabatan', 'tunj_masa_kerja', 'tunj_komunikasi',
    'tunj_transportasi', 'tunj_performance', 'tunj_tambahan', 'overtime',
    'pph21', 'bpjs_kesehatan', 'bpjs_ketenagakerjaan', 'potongan_lain', 'pinjaman'
];

function populateFields(data) {
    rupiahFields.forEach(field => {
        const display = document.getElementById('display_' + field);
        const hidden  = document.getElementById('field_' + field);
        const val = (data && data[field]) ? data[field] : 0;
        if (hidden) hidden.value = val;
        if (display) display.value = (val && Number(val) > 0) ? formatRupiah(val) : '0';
    });
}

function initRupiahInputs() {
    rupiahFields.forEach(field => {
        const display = document.getElementById('display_' + field);
        const hidden  = document.getElementById('field_' + field);
        if (!display || !hidden) return;

        // Initialize display from hidden
        const raw = hidden.value || '0';
        display.value = (raw === '0' || raw === '') ? '0' : formatRupiah(raw);

        // While typing
        display.addEventListener('input', function() {
            const rawVal = unformatRupiah(this.value);
            if (rawVal === '' || isNaN(rawVal)) {
                this.value = '';
                hidden.value = '0';
                return;
            }
            this.value = formatRupiah(rawVal);
            hidden.value = rawVal;
        });

        // On blur, ensure normalized display
        display.addEventListener('blur', function() {
            const rawVal = unformatRupiah(this.value);
            this.value = (rawVal === '0' || rawVal === '') ? '0' : formatRupiah(rawVal);
            hidden.value = rawVal || '0';
        });
    });
}

// Override resetFields to also reset display inputs
function resetFields() {
    rupiahFields.forEach(field => {
        const display = document.getElementById('display_' + field);
        const hidden  = document.getElementById('field_' + field);
        if (display) display.value = '0';
        if (hidden)  hidden.value  = '0';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initRupiahInputs();
});
</script>
<script>
// Data slip yang sudah ada untuk keperluan edit
const slipData = {
    @foreach($slips as $slip)
    {{ $slip->id }}: {
        gaji_pokok: {{ $slip->gaji_pokok }},
        tunj_jabatan: {{ $slip->tunj_jabatan }},
        tunj_masa_kerja: {{ $slip->tunj_masa_kerja }},
        tunj_komunikasi: {{ $slip->tunj_komunikasi }},
        tunj_transportasi: {{ $slip->tunj_transportasi }},
        tunj_performance: {{ $slip->tunj_performance }},
        tunj_tambahan: {{ $slip->tunj_tambahan }},
        overtime: {{ $slip->overtime }},
        pph21: {{ $slip->pph21 }},
        bpjs_kesehatan: {{ $slip->bpjs_kesehatan }},
        bpjs_ketenagakerjaan: {{ $slip->bpjs_ketenagakerjaan }},
        potongan_lain: {{ $slip->potongan_lain }},
        pinjaman: {{ $slip->pinjaman }},
    },
    @endforeach
};

const periodeId = {{ $periode->id }};

function openModal(karyawanId, nama, jabatan, nip) {
    document.getElementById('modalNama').textContent = 'Input Gaji — ' + nama;
    document.getElementById('modalInfo').textContent = nip + ' · ' + jabatan;

    // Set form action
    document.getElementById('formGaji').action = `/periode/${periodeId}/slip/input/${karyawanId}`;

    // Reset semua field ke 0
    resetFields();

    showModal();
}

function openModalEdit(karyawanId, nama, jabatan, nip, slipId) {
    document.getElementById('modalNama').textContent = 'Edit Gaji — ' + nama;
    document.getElementById('modalInfo').textContent = nip + ' · ' + jabatan;

    // Set form action
    document.getElementById('formGaji').action = `/periode/${periodeId}/slip/input/${karyawanId}`;

    // Isi field dengan data existing
    const data = slipData[slipId];
    if (data) {
        populateFields(data);
    }

    showModal();
}

function resetFields() {
    const fields = [
        'gaji_pokok','tunj_jabatan','tunj_masa_kerja','tunj_komunikasi',
        'tunj_transportasi','tunj_performance','tunj_tambahan','overtime',
        'pph21','bpjs_kesehatan','bpjs_ketenagakerjaan','potongan_lain','pinjaman'
    ];
    fields.forEach(f => {
        const el = document.getElementById('field_' + f);
        if (el) el.value = 0;
    });
}

function showModal() {
    const modal = document.getElementById('modalGaji');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('modalGaji');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

</script>

@endsection