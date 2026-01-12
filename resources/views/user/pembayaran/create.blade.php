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
                                    <td>: {{ $servis->booking->kendaraan->merk ?? '-' }} {{ $servis->booking->kendaraan->model ?? '-' }}
                                            ({{ $servis->booking->kendaraan->plat_nomor ?? '-' }})</td>
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
                                enctype="multipart/form-data" id="paymentForm">
                                @csrf

                                <div class="mb-3">
                                    <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                                    <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-select" required>
                                        <option value="">Pilih Jenis Pembayaran</option>
                                        <option value="dp" {{ old('jenis_pembayaran') == 'dp' ? 'selected' : '' }}>Down Payment
                                            (DP)</option>
                                        @if($servis->status == 'selesai' && $totalBayar == 0)
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

                                <div class="mb-3" id="jumlah-container" style="display: none;">
                                    <label for="jumlah" class="form-label">Jumlah Pembayaran (Rp)</label>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control" min="1000"
                                        value="{{ old('jumlah') }}">
                                    <small class="text-muted">Minimal Rp 1.000</small>
                                </div>

                                <div class="mb-3">
                                    <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                                        <option value="tunai" {{ old('metode_pembayaran', 'tunai') == 'tunai' ? 'selected' : '' }}>Tunai
                                            (Bayar di Bengkel)</option>
                                        <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>
                                            Transfer Bank</option>
                                    </select>
                                </div>

                                {{-- Info Rekening Bank - tampil saat pilih Transfer --}}
                                <div class="mb-3 alert alert-info" id="rekening-info" style="display: none;">
                                    <h6 class="alert-heading"><i class="bi bi-bank me-2"></i>Informasi Rekening Transfer</h6>
                                    <hr>
                                    <p class="mb-2"><strong>Bank:</strong> BCA</p>
                                    <p class="mb-2"><strong>Nomor Rekening:</strong> 1234567890</p>
                                    <p class="mb-2"><strong>Atas Nama:</strong> Bengkel Mobil Sejahtera</p>
                                    <hr class="my-2">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Silakan transfer sesuai jumlah yang akan dibayar, kemudian upload bukti transfer di bawah.
                                    </small>
                                </div>

                                <div class="mb-3" id="bukti-container" style="display: none;">
                                    <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control"
                                        accept="image/*">
                                    <small class="text-muted">Wajib jika metode pembayaran adalah Transfer (JPG, PNG, max
                                        10MB).</small>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">Kirim Pembayaran</button>
                                    <a href="{{ route('user.servis') }}" class="btn btn-secondary">Batal</a>
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

            // Handle submit form prevent double click
            document.getElementById('paymentForm').addEventListener('submit', function() {
                const btn = document.getElementById('btnSubmit');
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
            });

            // Handle jenis pembayaran change
            document.getElementById('jenis_pembayaran').addEventListener('change', function () {
                const jumlahContainer = document.getElementById('jumlah-container');
                const jumlahInput = document.getElementById('jumlah');

                if (this.value === '') {
                    // Belum pilih - hide
                    jumlahContainer.style.display = 'none';
                    jumlahInput.value = '';
                } else if (this.value === 'full') {
                    // Jika Lunas, hide input dan auto-fill dengan total
                    jumlahContainer.style.display = 'none';
                    jumlahInput.value = estimasiBiaya;
                } else if (this.value === 'pelunasan') {
                    // Jika pelunasan, show dan auto-fill dengan sisa
                    jumlahContainer.style.display = 'block';
                    jumlahInput.value = sisaTagihan;
                    jumlahInput.readOnly = true; // Read-only untuk pelunasan
                } else if (this.value === 'dp') {
                    // DP - show input dan bisa edit
                    jumlahContainer.style.display = 'block';
                    jumlahInput.value = '';
                    jumlahInput.readOnly = false;
                }
            });

            // Handle metode pembayaran change
            document.getElementById('metode_pembayaran').addEventListener('change', function () {
                const buktiContainer = document.getElementById('bukti-container');
                const rekeningInfo = document.getElementById('rekening-info');
                const buktiInput = document.getElementById('bukti_pembayaran');

                if (this.value === 'transfer') {
                    // Tampilkan info rekening dan bukti pembayaran
                    rekeningInfo.style.display = 'block';
                    buktiContainer.style.display = 'block';
                    buktiInput.required = true;
                } else {
                    // Sembunyikan untuk tunai
                    rekeningInfo.style.display = 'none';
                    buktiContainer.style.display = 'none';
                    buktiInput.required = false;
                }
            });

            // Trigger on page load - default tunai (semua hidden)
            document.addEventListener('DOMContentLoaded', function() {
                // Default: jumlah hidden, bukti hidden, rekening hidden
                document.getElementById('jumlah-container').style.display = 'none';
                document.getElementById('bukti-container').style.display = 'none';
                document.getElementById('rekening-info').style.display = 'none';

                // Jika ada old input, trigger change
                const oldJenisPembayaran = document.getElementById('jenis_pembayaran').value;
                if(oldJenisPembayaran) {
                    document.getElementById('jenis_pembayaran').dispatchEvent(new Event('change'));
                }

                const oldMetode = document.getElementById('metode_pembayaran').value;
                if(oldMetode === 'transfer') {
                    document.getElementById('metode_pembayaran').dispatchEvent(new Event('change'));
                }
            });
        </script>
@endsection