@extends('layouts.app')

@section('title', 'Pembayaran Servis')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex align-items-center mb-4">
                    <a href="{{ route('user.servis') }}" class="btn btn-outline-secondary btn-sm me-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h4 class="mb-0 fw-bold">Pembayaran Servis #{{ $servis->id }}</h4>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <!-- Left Column: Form -->
                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-4">Detail Pembayaran</h6>
                                
                                <form action="{{ route('user.pembayaran.store', $servis->id) }}" method="POST"
                                    enctype="multipart/form-data" id="paymentForm">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="jenis_pembayaran" class="form-label fw-semibold">Jenis Pembayaran</label>
                                        <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-select form-select-lg" required>
                                            <option value="">Pilih Jenis Pembayaran</option>
                                            <option value="dp" {{ old('jenis_pembayaran') == 'dp' ? 'selected' : '' }}>Down Payment (DP)</option>
                                            
                                            {{-- Lunas (Full) logic in JS will handle the actual amount including discounts --}}
                                            @if($servis->status == 'selesai' && $previouslyPaid == 0)
                                                <option value="full" {{ old('jenis_pembayaran') == 'full' ? 'selected' : '' }}>Bayar Lunas (Lengkap)</option>
                                            @endif
                                            
                                            @if($previouslyPaid > 0)
                                                <option value="pelunasan" {{ old('jenis_pembayaran') == 'pelunasan' ? 'selected' : '' }}>Pelunasan Sisa</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="mb-3" id="jumlah-container" style="display: none;">
                                        <label for="jumlah" class="form-label fw-semibold">Jumlah yang Akan Dibayar (Rp)</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light text-muted">Rp</span>
                                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="0" value="{{ old('jumlah') }}">
                                        </div>
                                    </div>

                                    <!-- Voucher Section -->
                                    <div class="mb-4 pt-3 border-top">
                                        <label class="form-label fw-semibold">Punya Kode Voucher?</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-uppercase" id="kode_voucher_input" placeholder="Masukkan kode promo...">
                                            <button class="btn btn-outline-primary" type="button" id="btnCheckVoucher">
                                                <i class="bi bi-tag me-1"></i> Gunakan Kode
                                            </button>
                                        </div>
                                        <div id="voucherFeedback" class="form-text mt-1"></div>
                                        <input type="hidden" name="kode_voucher" id="kode_voucher" value="{{ old('kode_voucher') }}">
                                    </div>

                                    <div class="mb-3 pt-3 border-top">
                                        <label for="metode_pembayaran" class="form-label fw-semibold">Metode Pembayaran</label>
                                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                                            <option value="tunai" {{ old('metode_pembayaran', 'tunai') == 'tunai' ? 'selected' : '' }}>Bayar di Kasir (Cash/QRIS)</option>
                                            <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                        </select>
                                    </div>

                                    {{-- Info Rekening --}}
                                    <div class="mb-3 p-3 rounded" id="rekening-info" style="display: none; background-color: #f0f7ff; border: 1px solid #cce5ff;">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-info-circle-fill text-primary me-2"></i>
                                            <span class="fw-bold text-primary">Rekening Transfer</span>
                                        </div>
                                        <div class="small">
                                            <div><strong>Bank BCA:</strong> 1234567890</div>
                                            <div><strong>A.N:</strong> Kings Bengkel Mobil</div>
                                        </div>
                                    </div>

                                    <div class="mb-4" id="bukti-container" style="display: none;">
                                        <label for="bukti_pembayaran" class="form-label fw-semibold">Upload Bukti Transfer <span class="text-danger">*</span></label>
                                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control" accept="image/*">
                                    </div>

                                    <div class="d-grid pt-2">
                                        <button type="submit" class="btn btn-primary btn-lg fw-bold" id="btnSubmit">
                                            Kirim Konfirmasi Pembayaran
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Summary -->
                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
                            <div class="card-header bg-white py-3">
                                <h6 class="fw-bold mb-0">Ringkasan Biaya</h6>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr class="border-bottom">
                                            <td class="ps-4 py-3 text-muted">Subtotal Servis</td>
                                            <td class="pe-4 py-3 text-end fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-4 py-2 text-success">
                                                <i class="bi bi-star-fill me-1"></i> Diskon Member
                                                <span class="small text-muted d-block">{{ auth()->user()->membershipTier->nama_level ?? 'Bronze' }} Member</span>
                                            </td>
                                            <td class="pe-4 py-2 text-end text-success">- Rp {{ number_format($diskonMember, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-4 py-2 text-info">
                                                <i class="bi bi-ticket-perforated-fill me-1"></i> Diskon Voucher
                                            </td>
                                            <td class="pe-4 py-2 text-end text-info" id="summaryVoucherDisc">- Rp 0</td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <td class="ps-4 py-3 fw-bold h5">Grand Total</td>
                                            <td class="pe-4 py-3 text-end fw-bold h5 text-primary" id="summaryGrandTotal">
                                                Rp {{ number_format(max(0, $subtotal - $diskonMember), 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @if($previouslyPaid > 0)
                                            <tr class="bg-light">
                                                <td class="ps-4 py-2 text-muted">Sudah Dibayar</td>
                                                <td class="pe-4 py-2 text-end text-success">Rp {{ number_format($previouslyPaid, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr class="bg-light">
                                                <td class="ps-4 py-2 fw-bold">Sisa Tagihan</td>
                                                <td class="pe-4 py-2 text-end fw-bold text-danger" id="summaryRemaining">
                                                    Rp {{ number_format(max(0, ($subtotal - $diskonMember) - $previouslyPaid), 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card border-0 bg-light p-3" style="border-radius: 12px;">
                            <h6 class="fw-bold small mb-2"><i class="bi bi-info-circle me-1"></i>Catatan:</h6>
                            <ul class="small text-muted mb-0 ps-3">
                                <li>Diskon membership dihitung otomatis berdasarkan level anda.</li>
                                <li>Pastikan nominal yang anda bayar sesuai dengan grand total setelah diskon.</li>
                                <li>Admin akan memverifikasi pembayaran anda dalam waktu 1x24 jam.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const DATA = {
            subtotal: {{ $subtotal }},
            diskonMember: {{ $diskonMember }},
            previouslyPaid: {{ $previouslyPaid }},
            userId: {{ auth()->id() }},
            csrfToken: "{{ csrf_token() }}",
            checkVoucherUrl: "{{ route('admin.vouchers.check') }}"
        };

        let state = {
            diskonVoucher: 0,
            grandTotal: {{ max(0, $subtotal - $diskonMember) }}
        };

        const els = {
            jenis: document.getElementById('jenis_pembayaran'),
            jumlahContainer: document.getElementById('jumlah-container'),
            jumlahInput: document.getElementById('jumlah'),
            metode: document.getElementById('metode_pembayaran'),
            rekeningInfo: document.getElementById('rekening-info'),
            buktiContainer: document.getElementById('bukti-container'),
            buktiInput: document.getElementById('bukti_pembayaran'),
            
            voucherInput: document.getElementById('kode_voucher_input'),
            voucherBtn: document.getElementById('btnCheckVoucher'),
            voucherFeedback: document.getElementById('voucherFeedback'),
            voucherHidden: document.getElementById('kode_voucher'),
            
            summaryVoucher: document.getElementById('summaryVoucherDisc'),
            summaryGrandTotal: document.getElementById('summaryGrandTotal'),
            summaryRemaining: document.getElementById('summaryRemaining'),
            
            form: document.getElementById('paymentForm'),
            submitBtn: document.getElementById('btnSubmit')
        };

        function formatRp(num) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
        }

        function updateTotals() {
            state.grandTotal = Math.max(0, DATA.subtotal - DATA.diskonMember - state.diskonVoucher);
            const remaining = Math.max(0, state.grandTotal - DATA.previouslyPaid);
            
            els.summaryVoucher.innerText = '- ' + formatRp(state.diskonVoucher);
            els.summaryGrandTotal.innerText = formatRp(state.grandTotal);
            if (els.summaryRemaining) {
                els.summaryRemaining.innerText = formatRp(remaining);
            }
            
            // Sync current input if needed
            if (els.jenis.value === 'full') {
                els.jumlahInput.value = state.grandTotal;
            } else if (els.jenis.value === 'pelunasan') {
                els.jumlahInput.value = remaining;
            }
        }

        els.voucherBtn.addEventListener('click', async () => {
             const code = els.voucherInput.value.trim();
             if(!code) return;
             
             els.voucherBtn.disabled = true;
             els.voucherBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
             
             try {
                const response = await fetch(DATA.checkVoucherUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': DATA.csrfToken
                    },
                    body: JSON.stringify({ 
                        code: code, 
                        subtotal: DATA.subtotal,
                        servis_id: "{{ $servis->id }}",
                        user_id: DATA.userId
                    })
                });
                
                const data = await response.json();
                
                if (data.valid) {
                    state.diskonVoucher = data.amount;
                    els.voucherHidden.value = code;
                    els.voucherFeedback.innerHTML = `<span class="text-success small fw-bold"><i class="bi bi-check-circle"></i> Berhasil! Potongan ${formatRp(data.amount)}</span>`;
                } else {
                    state.diskonVoucher = 0;
                    els.voucherHidden.value = '';
                    els.voucherFeedback.innerHTML = `<span class="text-danger small"><i class="bi bi-x-circle"></i> ${data.message}</span>`;
                }
                updateTotals();

             } catch (error) {
                 els.voucherFeedback.innerText = "Error sistem";
             } finally {
                 els.voucherBtn.disabled = false;
                 els.voucherBtn.innerHTML = '<i class="bi bi-tag me-1"></i> Gunakan Kode';
             }
        });

        els.jenis.addEventListener('change', function () {
            const remaining = Math.max(0, state.grandTotal - DATA.previouslyPaid);
            
            if (this.value === 'full') {
                els.jumlahContainer.style.display = 'block'; // Diubah jadi block agar transparan ke user berapa yang dibayar
                els.jumlahInput.value = state.grandTotal;
                els.jumlahInput.readOnly = true;
            } else if (this.value === 'pelunasan') {
                els.jumlahContainer.style.display = 'block';
                els.jumlahInput.value = remaining;
                els.jumlahInput.readOnly = true;
            } else if (this.value === 'dp') {
                els.jumlahContainer.style.display = 'block';
                els.jumlahInput.value = '';
                els.jumlahInput.readOnly = false;
            } else {
                els.jumlahContainer.style.display = 'none';
            }
        });

        els.metode.addEventListener('change', function () {
            if (this.value === 'transfer') {
                els.rekeningInfo.style.display = 'block';
                els.buktiContainer.style.display = 'block';
                els.buktiInput.required = true;
            } else {
                els.rekeningInfo.style.display = 'none';
                els.buktiContainer.style.display = 'none';
                els.buktiInput.required = false;
            }
        });

        els.jumlahInput.addEventListener('input', function() {
            if (els.jenis.value === 'dp') {
                const val = parseFloat(this.value) || 0;
                if (val >= state.grandTotal) {
                    this.classList.add('is-invalid');
                    if (!document.getElementById('dp-error')) {
                        const err = document.createElement('div');
                        err.id = 'dp-error';
                        err.className = 'invalid-feedback';
                        err.innerText = 'Jumlah DP harus kurang dari total biaya (' + formatRp(state.grandTotal) + ')';
                        this.parentNode.appendChild(err);
                    }
                } else {
                    this.classList.remove('is-invalid');
                    const err = document.getElementById('dp-error');
                    if (err) err.remove();
                }
            }
        });

        els.form.addEventListener('submit', function(e) {
            if (els.jenis.value === 'dp') {
                const val = parseFloat(els.jumlahInput.value) || 0;
                if (val >= state.grandTotal) {
                    e.preventDefault();
                    alert('Jumlah DP tidak boleh menyamai atau melebihi total biaya. Silakan pilih jenis pembayaran "Lunas" jika ingin membayar penuh.');
                    return;
                }
            }
            els.submitBtn.disabled = true;
            els.submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';
        });

        // Initialize state
        updateTotals();
    </script>
@endsection