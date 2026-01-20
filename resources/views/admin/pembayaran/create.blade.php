@extends('layouts.app')

@section('title', 'Input Pembayaran Manual')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h4 mb-0 fw-bold text-primary"><i class="bi bi-wallet2 me-2"></i>Kasir & Pembayaran</h2>
        <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>


    <div class="row">
        <!-- Left Column: Customer & Discount Details -->
        <div class="col-lg-8">
            <!-- Customer Info -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-person-lines-fill me-2"></i>Informasi Pelanggan</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small text-muted text-uppercase">Pelanggan</label>
                            <div class="fw-bold">{{ $servis->booking->user->nama }}</div>
                            @if($servis->booking->user->membershipTier)
                                <div class="badge bg-warning text-dark mt-1">
                                    <i class="bi bi-star-fill me-1"></i> {{ $servis->booking->user->membershipTier->nama_level }} Member
                                </div>
                            @else
                                <div class="badge bg-secondary mt-1">Bronze Member (Default)</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted text-uppercase">Kendaraan</label>
                            <div class="fw-bold">{{ $servis->booking->kendaraan->plat_nomor }}</div>
                            <div class="text-muted small">{{ $servis->booking->kendaraan->merk }} {{ $servis->booking->kendaraan->model }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Discount Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-success"><i class="bi bi-tags-fill me-2"></i>Potongan & Diskon</h6>
                </div>
                <div class="card-body">
                    <form id="paymentForm" action="{{ route('admin.pembayaran.store', $servis->id) }}" method="POST">
                        @csrf
                        
                        <!-- 1. Auto Member Discount (Hidden Input for Controller to recalc, but shown in UI) -->
                        <div class="mb-4 p-3 bg-light rounded border">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold text-dark">Diskon Membership</div>
                                    <div class="small text-muted">Otomatis berdasarkan level member</div>
                                </div>
                                <div class="fs-5 fw-bold text-success" id="displayMemberDesc">- Rp 0</div>
                            </div>
                        </div>

                        <!-- 2. Voucher Input -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Kode Voucher</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-uppercase" id="kode_voucher_input" placeholder="Masukkan kode..." aria-describedby="btnCheckVoucher">
                                <button class="btn btn-outline-primary" type="button" id="btnCheckVoucher">
                                    <i class="bi bi-tag me-1"></i> Gunakan Kode
                                </button>
                            </div>
                            <div id="voucherFeedback" class="form-text mt-2"></div>
                            <!-- Hidden Valid Code for Submit -->
                            <input type="hidden" name="kode_voucher" id="kode_voucher" value="{{ old('kode_voucher') }}">
                        </div>

                        <!-- 3. Manual Discount -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Diskon Manual / Negosiasi</label>
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" name="diskon_manual" id="diskon_manual" value="{{ old('diskon_manual', 0) }}" min="0">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="alasan_diskon_manual" id="alasan_diskon_manual" value="{{ old('alasan_diskon_manual') }}" placeholder="Alasan wajib diisi (Contoh: Teman Owner)">
                                </div>
                            </div>
                            <div class="form-text mt-1" id="manualReasonError">
                                <span class="text-danger d-none" id="errorMsg"><i class="bi bi-exclamation-triangle me-1"></i>Alasan wajib diisi jika ada diskon manual.</span>
                                <span class="text-muted" id="defaultMsg">Berikan alasan mengapa diskon diberikan.</span>
                            </div>
                        </div>

                </div>
            </div>
            
            <!-- Payment Input -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-credit-card py-1 me-2"></i>Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Metode Pembayaran</label>
                            <select name="metode_pembayaran" class="form-select form-select-lg">
                                <option value="tunai">Tunai (Cash)</option>
                                <option value="BCA">Transfer BCA</option>
                                <option value="Mandiri">Transfer Mandiri</option>
                                <option value="DANA">E-Wallet DANA</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Bayar Sekarang (Rp)</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-success text-white">Rp</span>
                                <input type="number" name="jumlah" id="jumlah_bayar" class="form-control fw-bold text-success" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                         <label class="form-label">Catatan</label>
                         <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Summary Sticky -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 card-title"><i class="bi bi-receipt me-2"></i>Ringkasan Biaya</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless mb-0">
                        <tbody class="align-middle">
                            <tr class="border-bottom">
                                <td class="ps-4 py-3 text-muted">Subtotal Servis</td>
                                <td class="pe-4 py-3 text-end fw-bold" id="summarySubtotal">Rp 0</td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-2 text-success"><i class="bi bi-star-fill me-1"></i> Diskon Member</td>
                                <td class="pe-4 py-2 text-end text-success" id="summaryMemberDisc">- Rp 0</td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-2 text-info"><i class="bi bi-ticket-fill me-1"></i> Diskon Voucher</td>
                                <td class="pe-4 py-2 text-end text-info" id="summaryVoucherDisc">- Rp 0</td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="ps-4 py-2 text-warning"><i class="bi bi-pencil-fill me-1"></i> Diskon Manual</td>
                                <td class="pe-4 py-2 text-end text-warning" id="summaryManualDisc">- Rp 0</td>
                            </tr>
                            <tr class="bg-light">
                                <td class="ps-4 py-3 fw-bold h5 mb-0">Grand Total</td>
                                <td class="pe-4 py-3 text-end fw-bold h5 mb-0 text-primary" id="summaryGrandTotal">Rp 0</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="p-4">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg py-3 shadow-sm" id="btnSubmit">
                                            <i class="bi bi-check-circle-fill me-2"></i> PROSES BAYAR
                                        </button>
                                    </div>
                                    <div class="text-center mt-2 small text-muted">
                                        Pastikan data sudah benar sebelum proses.
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                     </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Data for JS --}}
<script>
    // Data from Server
    const SERVER_DATA = {
        subtotal: {{ $servis->estimasi_biaya }},
        userId: {{ $servis->booking->user->id }},
        previouslyPaid: {{ \App\Models\Pembayaran::where('servis_id', $servis->id)->where('status', 'diterima')->sum('jumlah') }},
        memberLevel: {!! json_encode($servis->booking->user->membershipTier) !!},
        // Assuming estimation includes parts. We need breakdown ideally, but for now apply flat percent logic if simple.
        // Wait, controller has robust logic. Here we need Approx Logic for UI.
        // Let's fetch parts total to be accurate if possible, or just default to backend calc on submit.
        // For UI, we'll try to replicate logic.
        partTotal: {{ $servis->detailServis->sum('subtotal') ?? 0 }},
    };

    const routes = {
        checkVoucher: "{{ route('admin.vouchers.check') }}" // Needs to be POST
    };
    
    const csrfToken = "{{ csrf_token() }}";
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const els = {
            subtotal: document.getElementById('summarySubtotal'),
            memberDisc: document.getElementById('summaryMemberDisc'),
            voucherDisc: document.getElementById('summaryVoucherDisc'),
            manualDisc: document.getElementById('summaryManualDisc'),
            grandTotal: document.getElementById('summaryGrandTotal'),
            
            displayMemberDesc: document.getElementById('displayMemberDesc'),
            
            voucherInput: document.getElementById('kode_voucher_input'),
            voucherHidden: document.getElementById('kode_voucher'),
            voucherBtn: document.getElementById('btnCheckVoucher'),
            voucherFeedback: document.getElementById('voucherFeedback'),
            
            manualInput: document.getElementById('diskon_manual'),
            manualReason: document.getElementById('alasan_diskon_manual'),
            manualError: document.getElementById('manualReasonError'),
            
            payInput: document.getElementById('jumlah_bayar'),
            form: document.getElementById('paymentForm'),
        };

        // State
        let state = {
            subtotal: SERVER_DATA.subtotal,
            partTotal: SERVER_DATA.partTotal,
            jasaTotal: Math.max(0, SERVER_DATA.subtotal - SERVER_DATA.partTotal),
            
            memberDiscVal: 0,
            voucherDiscVal: 0,
            manualDiscVal: 0,
            
            isValidVoucher: false,
        };

        // Format Currency
        const formatRp = (num) => 'Rp ' + new Intl.NumberFormat('id-ID').format(num);

        // 1. Calculate Member Discount (Replicating Service Logic)
        function calcMemberDisc() {
            if (!SERVER_DATA.memberLevel) return 0;
            const tier = SERVER_DATA.memberLevel;
            
            // Jasa * Diskon Jasa + Part * Diskon Part
            let discJasa = state.jasaTotal * (parseFloat(tier.diskon_jasa) / 100);
            let discPart = state.partTotal * (parseFloat(tier.diskon_part) / 100);
            
            return Math.round(discJasa + discPart);
        }

        // 2. Update Calculations
        function updateTotals() {
            // Get Current Values
            state.manualDiscVal = parseFloat(els.manualInput.value) || 0;
            
            // Calc Member
            state.memberDiscVal = calcMemberDisc();
            
            // Grand Total
            let total = state.subtotal - state.memberDiscVal - state.voucherDiscVal - state.manualDiscVal;
            if (total < 0) total = 0;
            
            // Render
            els.subtotal.innerText = formatRp(state.subtotal);
            els.memberDisc.innerText = '- ' + formatRp(state.memberDiscVal);
            els.voucherDisc.innerText = '- ' + formatRp(state.voucherDiscVal);
            els.manualDisc.innerText = '- ' + formatRp(state.manualDiscVal);
            els.grandTotal.innerText = formatRp(total);
            
            els.displayMemberDesc.innerText = '- ' + formatRp(state.memberDiscVal);

            // Update Payment Input Recommendation (Remaining Bill)
            // If it's the first load or user hasn't typed manually?
            // Let's just update prompt. User can override.
            // Actually, best UX: if default, keep updating. If touched, don't.
            // Simplest: Always show remaining bill (Grand - Paid)
            let remaining = Math.max(0, total - SERVER_DATA.previouslyPaid);
            els.payInput.value = remaining;
        }

        // 3. Voucher Check Logic
        els.voucherBtn.addEventListener('click', async () => {
             const code = els.voucherInput.value.trim();
             if(!code) return;
             
             els.voucherBtn.disabled = true;
             els.voucherBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
             
             try {
                const response = await fetch(routes.checkVoucher, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ 
                     code: code, 
                     subtotal: state.subtotal,
                     servis_id: "{{ $servis->id }}",
                     user_id: SERVER_DATA.userId
                    })
                });
                
                const data = await response.json();
                
                if (data.valid) {
                    state.voucherDiscVal = data.amount;
                    state.isValidVoucher = true;
                    els.voucherHidden.value = code; // Set Hidden for Post
                    
                    els.voucherFeedback.innerHTML = `<span class="text-success"><i class="bi bi-check-circle"></i> Voucher Valid: Potongan ${formatRp(data.amount)}</span>`;
                    updateTotals();
                } else {
                    state.voucherDiscVal = 0;
                    state.isValidVoucher = false;
                    els.voucherHidden.value = '';
                    
                    els.voucherFeedback.innerHTML = `<span class="text-danger"><i class="bi bi-x-circle"></i> ${data.message}</span>`;
                    updateTotals();
                }

             } catch (error) {
                 console.error(error);
                 els.voucherFeedback.innerText = "Error checking voucher";
             } finally {
                 els.voucherBtn.disabled = false;
                 els.voucherBtn.innerHTML = '<i class="bi bi-search me-1"></i> Cek Voucher';
             }
        });

        // 4. listeners
        els.manualInput.addEventListener('input', updateTotals);
        
        // Manual Reason Validation Hint
        els.manualReason.addEventListener('input', () => {
             if(els.manualReason.value.trim() !== '') {
                 document.getElementById('errorMsg').classList.add('d-none');
                 document.getElementById('defaultMsg').classList.remove('d-none');
                 els.manualReason.classList.remove('is-invalid');
             }
        });

        // Form Submit Validation
        els.form.addEventListener('submit', function(e) {
            if (state.manualDiscVal > 0 && els.manualReason.value.trim() === '') {
                e.preventDefault();
                document.getElementById('errorMsg').classList.remove('d-none');
                document.getElementById('defaultMsg').classList.add('d-none');
                els.manualReason.classList.add('is-invalid');
                els.manualReason.focus();
                return;
            }
            // Optional: Block if pay < grandtotal? No, allow DP.
        });

        // Init
        updateTotals();
    });
</script>
@endsection