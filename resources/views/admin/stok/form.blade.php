
<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label>Kode Barang</label>
        <input type="text" name="kode_barang" value="{{ old('kode_barang', $stok->kode_barang ?? '') }}" class="input">
    </div>
    <div>
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" value="{{ old('nama_barang', $stok->nama_barang ?? '') }}" class="input">
    </div>
</div>

<div class="grid grid-cols-3 gap-4 mb-4">
    <div>
        <label>Harga Beli</label>
        <input type="number" step="0.01" name="harga_beli" value="{{ old('harga_beli', $stok->harga_beli ?? 0) }}" class="input">
    </div>
    <div>
        <label>Harga Jual</label>
        <input type="number" step="0.01" name="harga_jual" value="{{ old('harga_jual', $stok->harga_jual ?? 0) }}" class="input">
    </div>
    <div>
        <label>Jumlah</label>
        <input type="number" name="jumlah" value="{{ old('jumlah', $stok->jumlah ?? 0) }}" class="input">
    </div>
</div>

<div class="mb-4">
    <label>Nomor Seri</label>
    <input type="text" name="nomor_seri" value="{{ old('nomor_seri', $stok->nomor_seri ?? '') }}" class="input">
</div>

<div class="mb-4">
    <label>Keterangan</label>
    <textarea name="keterangan" class="input">{{ old('keterangan', $stok->keterangan ?? '') }}</textarea>
</div>

<button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
<a href="{{ route('admin.stok.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Kembali</a>
