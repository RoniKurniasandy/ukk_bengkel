@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 p-4">
        <h3 class="fw-bold mb-3">Penjualan Stok Barang</h3>

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('admin.penjualan.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="fw-semibold">Pilih Barang</label>
                <select name="stok_id" id="stok_id" class="form-select" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($stok as $item)
                    <option value="{{ $item->stok_id }}" data-harga="{{ $item->harga_jual }}" data-stok="{{ $item->jumlah }}">
                        {{ $item->nama_barang }} (Stok: {{ $item->jumlah }}) - Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Total Harga</label>
                <input type="text" id="total_harga" class="form-control" readonly>
            </div>

            <button class="btn btn-primary px-4">Proses Penjualan</button>
            <a href="{{ route('admin.stok.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stokSelect = document.getElementById('stok_id');
        const jumlahInput = document.getElementById('jumlah');
        const totalInput = document.getElementById('total_harga');

        function hitungTotal() {
            const selectedOption = stokSelect.options[stokSelect.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            const jumlah = jumlahInput.value;

            if (harga && jumlah) {
                const total = harga * jumlah;
                totalInput.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
            } else {
                totalInput.value = '';
            }
        }

        stokSelect.addEventListener('change', hitungTotal);
        jumlahInput.addEventListener('input', hitungTotal);
    });
</script>
@endsection
