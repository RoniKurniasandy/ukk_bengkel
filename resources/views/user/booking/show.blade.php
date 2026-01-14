@extends('layouts.app')

@section('title', 'Detail Servis Saya')

@section('content')
    <div class="container py-4">
        {{-- Action Buttons (Hidden when printing) --}}
        <div class="d-flex justify-content-between mb-4 d-print-none">
            <a href="{{ route('user.servis') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            @if($booking->status == 'selesai')
                <button onclick="window.print()" class="btn btn-success">
                    <i class="bi bi-printer"></i> Cetak Nota
                </button>
            @endif
        </div>

        {{-- Invoice Card --}}
        <div class="card shadow-sm border-0" id="invoice-area">
            <div class="card-body p-4">
                {{-- Header --}}
                <div class="d-flex justify-content-between border-bottom pb-2 mb-3">
                    <div>
                        <h4 class="fw-bold mb-0">KINGS BENGKEL MOBIL</h4>
                        <p class="text-muted small mb-0">Jl. Raya Bengkel No. 123, Kota Otomotif | Telp: (021) 555-0123</p>
                    </div>
                    <div class="text-end">
                        <h4 class="fw-bold mb-0">NOTA SERVIS</h4>
                        <p class="small mb-0">#No: {{ str_pad($booking->booking_id, 5, '0', STR_PAD_LEFT) }}</p>
                        <p class="small mb-0">Tanggal: {{ $booking->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                {{-- Informasi Kendaraan --}}
                <div class="mb-2">
                    <h6 class="fw-bold text-uppercase small mb-1">Informasi Kendaraan</h6>
                    <table class="table table-sm table-borderless mb-0" style="font-size: 0.9rem;">
                        <tr>
                            <td width="130" class="py-0">Merk/Type</td>
                            <td class="py-0">: {{ $booking->kendaraan->merk }} {{ $booking->kendaraan->model }}</td>
                        </tr>
                        <tr>
                            <td class="py-0">Plat Nomor</td>
                            <td class="py-0">: <strong>{{ $booking->kendaraan->plat_nomor }}</strong></td>
                        </tr>
                    </table>
                </div>

                {{-- Detail Servis --}}
                <div class="mb-2">
                    <h6 class="fw-bold text-uppercase small mb-1">Detail Servis</h6>
                    <table class="table table-sm table-borderless mb-0" style="font-size: 0.9rem;">
                        <tr>
                            <td width="130" class="py-0">Jenis Layanan</td>
                            <td class="py-0">: {{ $booking->layanan->nama_layanan ?? 'Umum' }}</td>
                        </tr>
                        <tr>
                            <td class="py-0">Waktu Booking</td>
                            <td class="py-0">: <strong>{{ $booking->tanggal_booking->format('d M Y') }} -
                                    {{ $booking->jam_booking ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td class="py-0">Mekanik</td>
                            <td class="py-0">: {{ $booking->servis->mekanik->nama ?? '-' }}</td>
                        </tr>
                        @if($booking->servis && $booking->servis->waktu_mulai)
                            <tr>
                                <td class="py-0">Waktu Mulai</td>
                                <td class="py-0">: {{ $booking->servis->waktu_mulai->format('d M Y, H:i') }} WIB</td>
                            </tr>
                        @endif
                        @if($booking->servis && $booking->servis->waktu_selesai)
                            <tr>
                                <td class="py-0">Waktu Selesai</td>
                                <td class="py-0">: {{ $booking->servis->waktu_selesai->format('d M Y, H:i') }} WIB</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="py-0">Status</td>
                            <td class="py-0">: <span
                                    class="badge bg-{{ $booking->status == 'selesai' ? 'success' : 'warning' }} badge-sm">{{ ucfirst($booking->status) }}</span>
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- Keluhan --}}
                <div class="mb-3">
                    <h6 class="fw-bold text-uppercase small mb-1">Keluhan</h6>
                    <div class="border rounded p-2 bg-light" style="min-height: 50px; font-size: 0.9rem;">
                        {{ $booking->keluhan }}
                    </div>
                </div>

                {{-- Rincian Pekerjaan & Sparepart --}}
                @if($booking->servis && $booking->servis->detailServis->count() > 0)
                    <div class="mb-2">
                        <h6 class="fw-bold text-uppercase small mb-1">Rincian Pekerjaan & Sparepart</h6>
                        <table class="table table-bordered table-sm mb-0" style="font-size: 0.9rem;">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center py-1" width="30">No</th>
                                    <th class="py-1">Item/Jasa</th>
                                    <th class="text-center py-1" width="60">QTY</th>
                                    <th class="text-end py-1" width="110">Harga Satuan</th>
                                    <th class="text-end py-1" width="110">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalParts = 0; @endphp
                                @foreach($booking->servis->detailServis as $index => $detail)
                                    <tr>
                                        <td class="text-center py-1">{{ $index + 1 }}</td>
                                        <td class="py-1">{{ $detail->stok->nama_barang }}</td>
                                        <td class="text-center py-1">{{ $detail->jumlah }}</td>
                                        <td class="text-end py-1">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                        <td class="text-end py-1">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @php $totalParts += $detail->subtotal; @endphp
                                @endforeach

                                {{-- Biaya Jasa --}}
                                @php 
                                                            $totalBiaya = $booking->servis->estimasi_biaya ?? 0;
                                    $biayaJasa = $totalBiaya - $totalParts; 
                                @endphp
                                @if($biayaJasa > 0)
                                    <tr>
                                        <td class="text-center py-1">{{ $booking->servis->detailServis->count() + 1 }}</td>
                                        <td class="py-1">Biaya Jasa Servis</td>
                                        <td class="text-center py-1">1</td>
                                        <td class="text-end py-1">Rp {{ number_format($biayaJasa, 0, ',', '.') }}</td>
                                        <td class="text-end py-1">Rp {{ number_format($biayaJasa, 0, ',', '.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        {{-- Total Biaya --}}
                        <div class="border-top border-2 border-dark mt-1 pt-1">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-bold mb-0">TOTAL BIAYA</h6>
                                <h5 class="fw-bold text-success mb-0">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                @endif
            {{-- Non-complete status messages --}}
            @if($booking->status == 'menunggu')
                    <div class="border rounded p-2 bg-warning bg-opacity-10 mb-2" style="font-size: 0.85rem;">
                    <i class="bi bi-hourglass-split"></i> Booking Anda sedang menunggu konfirmasi dari admin.
                </div>
            @elseif($booking->status == 'disetujui')
                    <div class="border rounded p-2 bg-info bg-opacity-10 mb-2" style="font-size: 0.85rem;">
                    <i class="bi bi-tools"></i> Servis Anda sedang dikerjakan oleh mekanik kami.
                </div>
            @elseif($booking->status == 'ditolak')
                <div class="border rounded p-2 bg-danger bg-opacity-10 mb-2" style="font-size: 0.85rem;">
                    <i class="bi bi-x-circle"></i> Booking Anda tidak dapat diproses.
                </div>
            @endif

                {{-- Footer --}}
                @if($booking->status == 'selesai')
                    <div class="row mt-4 pt-2 border-top align-items-end">
                        <div class="col-md-6">
                            <p class="small mb-0">Terima kasih atas kepercayaan Anda.</p>
                            <p class="small mb-0">Garansi servis berlaku 1 minggu sejak tanggal nota ini.</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="small mb-5">Hormat Kami,</p>
                            <p class="fw-bold mb-0">BENGKEL MOBIL</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        @medi
    a print {
            body * {

                       visibility: hidden;
            }

            #invoice-area, #invoice-area * {
                visibility: visible;
            }
            #invoice-area {
                position: absolute;
                left: 0;
                top: 0;

       width: 100%;
                border: none !important;
                box-shadow: none !important;
            }

            .d-print-none {
                display: none !important;
            }
            @page {
                size: A4;
                margin: 10mm;
            }
        }
    </style>
@endsection
