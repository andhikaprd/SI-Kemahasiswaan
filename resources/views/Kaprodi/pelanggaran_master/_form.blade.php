@php($mode = isset($item) ? 'edit' : 'create')
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggaran</label>
        <input type="text" name="nama" value="{{ old('nama', $item->nama ?? '') }}" required
            class="w-full border rounded-lg px-3 py-2 @error('nama') border-red-500 @enderror">
        @error('nama')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <select name="kategori" required class="w-full border rounded-lg px-3 py-2 @error('kategori') border-red-500 @enderror">
                <option value="" disabled {{ old('kategori', $item->kategori ?? '') === '' ? 'selected' : '' }}>Pilih kategori</option>
                @foreach(['ringan' => 'Ringan','sedang' => 'Sedang','berat' => 'Berat'] as $val => $label)
                    <option value="{{ $val }}" {{ old('kategori', $item->kategori ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('kategori')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sanksi Default (opsional)</label>
            <input type="text" name="sanksi_default" value="{{ old('sanksi_default', $item->sanksi_default ?? '') }}"
                class="w-full border rounded-lg px-3 py-2 @error('sanksi_default') border-red-500 @enderror">
            @error('sanksi_default')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="3" class="w-full border rounded-lg px-3 py-2 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
        @error('deskripsi')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
    <div class="flex items-center justify-between">
        <a href="{{ route('kaprodi.pelanggaran_master.index') }}" class="px-4 py-2 rounded-lg border text-gray-700">Kembali</a>
        <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">{{ $mode === 'edit' ? 'Simpan Perubahan' : 'Simpan' }}</button>
    </div>
</div>
