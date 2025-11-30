@extends('layouts.app')

@section('title', 'Pembayaran Servis')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Pembayaran Servis</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Terjadi Kesalahan:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="mb-4">
                            <h6>Detail Servis</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td width="150">Layanan</td>
                                    <td>: {{ $servis->booking->layanan->nama_layanan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Kendaraan</td>
                                    <td>: {{ $servis->booking->kendaraan->nama_kendaraan ?? '-' }}
                                        ({{ $servis->booking->kendaraan->nomor_polisi ?? '-' }})</td>
                                </tr>
                                <tr>
                                    <td>Status Servis</td>
                                    <td>:
                                        @if($servis->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-info">{{ ucfirst($servis->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Estimasi Biaya</td>
                                    <td>: <strong>Rp {{ number_format($servis->estimasi_biaya, 0, ',', '.') }}</strong></td>
                                </tr>
                                @php
                                    $totalBayar = \App\Models\Pembayaran::where('servis_id', $servis->id)
                                        ->where('status', 'diterima')
                                        ->sum('jumlah');
                                    $sisaTagihan = max(0, $servis->estimasi_biaya - $totalBayar);
                                @endphp
                                @if($totalBayar > 0)
                                    <tr>
                                        <td>Sudah Dibayar</td>
                                        <td>: <span class="text-success">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sisa Tagihan</td>
                                        <td>: <strong class="text-danger">Rp
                                                {{ number_format($sisaTagihan, 0, ',', '.') }}</strong></td>
                                    </tr>
                                @endif
                            </table>
                        </div>

                        <form action="{{ route('user.pembayaran.store', $servis->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                                <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-select" required>
                                    <option value="">Pilih Jenis Pembayaran</option>
                                    <option value="dp" {{ old('jenis_pembayaran') == 'dp' ? 'selected' : '' }}>Down Payment
                                        (DP)</option>
                                    @if($servis->status == 'selesai')
                                        <option value="full" {{ old('jenis_pembayaran') == 'full' ? 'selected' : '' }}>Bayar Lunas
                                            (Full)</option>
                                    @endif
                                    @if($totalBayar > 0)
                                        <option value="pelunasan" {{ old('jenis_pembayaran') == 'pelunasan' ? 'selected' : '' }}>
                                            Pelunasan Sisa</option>
                                    @endif
                                </select>
                                @if($servis->status != 'selesai')
                                    <small class="text-muted">* Pembayaran Lunas hanya bisa dilakukan setelah servis
                                        selesai</small>
                                @endif
                            </div>

                            <div class="mb-3" id="jumlah-container">
                                <label for="jumlah" class="form-label">Jumlah Pembayaran (Rp)</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1000"
                                    value="{{ old('jumlah') }}">
                                <small class="text-muted">Minimal Rp 1.000</small>
                            </div>

                            <div class="mb-3">
                                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                                    <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>
                                        Transfer Bank</option>
                                    <option value="tunai" {{ old('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai
                                        (Bayar di Bengkel)</option>
                                </select>
                            </div>

                            <div class="mb-3" id="bukti-container">
                                <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran <span
                                        class="text-danger">*</span></label>
                                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control"
                                    accept="image/*">
                                <small class="text-muted">Wajib jika metode pembayaran adalah Transfer (JPG, PNG, max
                                    10MB).</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Kirim Pembayaran</button>
                                <a href="{{ route('dashboard.user') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const estimasiBiaya = {{ $servis->estimasi_biaya }};
        const sisaTagihan = {{ $sisaTagihan }};

        // Handle jenis pembayaran change
        document.getElementById('jenis_pembayaran').addEventListener('change', function () {
            const jumlahContainer = document.getElementById('jumlah-container');
            const jumlahInput = document.getElementById('jumlah');

            if (this.value === 'full') {
                // Jika Lunas, hide input dan auto-fill dengan total
                jumlahContainer.style.display = 'none';
                jumlahInput.value = estimasiBiaya;
            } else if (this.value === 'pelunasan') {
                // Jika pelunasan, auto-fill dengan sisa
                jumlahContainer.style.display = 'block';
                jumlahInput.value = sisaTagihan;
            } else {
                // DP - show input
                jumlahContainer.style.display = 'block';
                jumlahInput.value = '';
            }
        });

        // Handle metode pembayaran change
        document.getElementById('metode_pembayaran').addEventListener('change', function () {
            const buktiContainer = document.getElementById('bukti-container');
            const buktiInput = document.getElementById('bukti_pembayaran');

            if (this.value === 'tunai') {
                buktiContainer.style.display = 'none';
            } else {
                buktiContainer.style.display = 'block';
            }
        });

        // Trigger on page load if needed
        if (document.getElementById('metode_pembayaran').value === 'tunai') {
            document.getElementById('bukti-container').style.display = 'none';
        }
    </script>
@endsection