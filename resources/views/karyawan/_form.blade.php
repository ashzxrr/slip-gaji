@php $k = $karyawan ?? null; @endphp

<div class="grid grid-cols-1 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" name="nama" value="{{ old('nama', $k->nama ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-green-500" required>
        @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
            <input type="text" name="nip" value="{{ old('nip', $k->nip ?? '') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                          focus:outline-none focus:ring-2 focus:ring-green-500" required>
            @error('nip')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
            <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', $k->no_whatsapp ?? '') }}"
                   placeholder="628xxxxxxxxxx"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                          focus:outline-none focus:ring-2 focus:ring-green-500" required>
            <p class="text-xs text-gray-400 mt-1">Format: 628xxxxxxxxxx</p>
            @error('no_whatsapp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        {{-- Jabatan --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
            <input type="text" name="jabatan"
                   value="{{ old('jabatan', $k->jabatan ?? '') }}"
                   list="jabatan-list"
                   placeholder="Pilih atau ketik jabatan..."
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                          focus:outline-none focus:ring-2 focus:ring-green-500" required>
            <datalist id="jabatan-list">
                <option value="TL Cuci">
                <option value="TL Cabut">
                <option value="TL Moulding">
                <option value="TL Kedatangan">
                <option value="TL Pengiriman">
                <option value="TL Cutter & Flek">
                <option value="GTL Moulding">
                <option value="GTL Cabut">
                <option value="GTL Packing">
                <option value="SPV Moulding">
                <option value="SPV Kedatangan">
                <option value="Checker Cabut">
                <option value="Admin Produktivitas">
                <option value="Admin">
                <option value="Purchasing / Logistic">
                <option value="Finance Accounting">
                <option value="Payroll">
                <option value="HRD">
                <option value="Security">
                <option value="Driver">
                <option value="Operator">
                <option value="Superintenden">
                <option value="Ass. Superintenden">
            </datalist>
            @error('jabatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Departemen --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Departemen</label>
            <select name="departemen"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-green-500" required>
                <option value="">-- Pilih Departemen --</option>
                @foreach(['Produksi','Top Management', 'Support', 'Operation'] as $dep)
                    <option value="{{ $dep }}"
                        {{ old('departemen', $k->departemen ?? '') === $dep ? 'selected' : '' }}>
                        {{ $dep }}
                    </option>
                @endforeach
            </select>
            @error('departemen')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>
    

    <div class="flex items-center gap-2">
        <input type="checkbox" name="aktif" id="aktif" value="1"
               {{ old('aktif', $k->aktif ?? true) ? 'checked' : '' }}
               class="rounded border-gray-300 text-green-600">
        <label for="aktif" class="text-sm text-gray-700">Karyawan Aktif</label>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordField');
    const icon  = document.getElementById('eyeIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>