@extends('layouts.app')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Pengajuan ' . ($jenis === 'pra_penelitian' ? 'Pra Penelitian' : 'Magang'))

@section('content')
    <style>
        :root {
            --custom-maroon: #7c1316;
            --custom-maroon-light: #a3191d;
            --custom-maroon-subtle: #fcf0f1;
            --text-dark: #2c3e50;
            --text-muted: #64748b;
            --card-radius: 16px;
            --shadow-soft: 0 4px 20px rgba(0, 0, 0, 0.05);
            --transition: 0.3s ease;
        }

        /* --- Header --- */
        .page-header-wrapper {
            background: #fff;
            border-radius: var(--card-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-soft);
            margin-bottom: 2rem;
            border-left: 5px solid var(--custom-maroon);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* --- Status Card (Left) --- */
        .status-card-main {
            background: #fff;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow-soft);
            overflow: hidden;
            text-align: center;
            padding: 2rem;
            border: 1px solid #f0f0f0;
        }
        
        .status-icon-wrapper {
            width: 80px; height: 80px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
        }
        
        .bg-status-pending { background: #fff7ed; color: #c2410c; }
        .bg-status-success { background: #dcfce7; color: #166534; }
        .bg-status-danger { background: #fee2e2; color: #991b1b; }

        /* --- Step Cards (Right) --- */
        .step-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }
        
        .step-card:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border-color: var(--custom-maroon-light);
        }

        /* Garis vertikal konektor antar step (Opsional, visual saja) */
        .step-card::after {
            content: ''; position: absolute; left: 24px; top: 100%; height: 20px; 
            border-left: 2px dashed #cbd5e1; z-index: 0;
        }
        .step-card:last-child::after { display: none; }

        .step-header {
            padding: 1rem 1.5rem;
            background: #f8f9fa;
            border-bottom: 1px solid #f1f5f9;
            display: flex; align-items: center; gap: 1rem;
        }
        
        .step-header.active { background: var(--custom-maroon-subtle); color: var(--custom-maroon); }
        .step-header.done { background: #ecfdf5; color: #047857; }

        .step-number {
            width: 32px; height: 32px;
            background: #fff; border: 2px solid #cbd5e1; color: #64748b;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 0.9rem; z-index: 1;
        }
        
        .step-header.active .step-number { border-color: var(--custom-maroon); color: var(--custom-maroon); }
        .step-header.done .step-number { border-color: #10b981; background: #10b981; color: white; border: none; }

        .step-body { padding: 1.5rem; }

        /* --- Buttons --- */
        .btn-maroon {
            background-color: var(--custom-maroon); color: #fff; border: none;
            border-radius: 8px; padding: 0.6rem 1.5rem; font-weight: 600;
            transition: var(--transition);
        }
        .btn-maroon:hover { background-color: var(--custom-maroon-light); color: #fff; transform: translateY(-2px); }

        .btn-outline-custom {
            border: 1px solid #e2e8f0; color: var(--text-dark); background: white;
            border-radius: 8px; padding: 0.5rem 1.2rem; font-weight: 500; transition: var(--transition);
        }
        .btn-outline-custom:hover { background: #f8f9fa; border-color: #cbd5e1; }

        .file-download-box {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem; border: 1px solid #e2e8f0; border-radius: 8px;
            background: #fff; margin-bottom: 0.5rem; transition: var(--transition);
        }
        .file-download-box:hover { border-color: var(--custom-maroon); background: var(--custom-maroon-subtle); }

        .animate-up { animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; opacity: 0; transform: translateY(20px); }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="container py-4">

        {{-- Header --}}
        <div class="page-header-wrapper animate-up mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: var(--custom-maroon);">Detail Pengajuan</h4>
                <small class="text-muted">Lacak progres pengajuan {{ $jenis === 'pra_penelitian' ? 'Pra Penelitian' : 'Magang' }} Anda.</small>
            </div>
            <div>
                <a href="{{ route('pengajuan.index') }}" class="btn btn-outline-custom shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-up shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show animate-up shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- CONTENT UNTUK PRA PENELITIAN --}}
        @if ($jenis === 'pra_penelitian')
            @php
                $praPenelitian = App\Models\PraPenelitian::where('user_id', auth()->id())->first();
                
                // Helper untuk menentukan class step
                // Step 1: Form
                $step1Class = $praPenelitian ? ($praPenelitian->status == 'Approved' ? 'done' : ($praPenelitian->status == 'Rejected' ? 'active' : 'active')) : 'active';
                $step1Icon  = $praPenelitian && $praPenelitian->status == 'Approved' ? '<i class="bi bi-check-lg"></i>' : '1';
                
                // Step 2: Galasan
                $step2Class = '';
                $step2Icon = '2';
                if ($praPenelitian && $praPenelitian->status == 'Approved') {
                    $step2Class = $pengajuan->status_galasan == 'sent' ? 'done' : 'active';
                    $step2Icon = $pengajuan->status_galasan == 'sent' ? '<i class="bi bi-check-lg"></i>' : '2';
                }

                // Step 3: Pembayaran & Penempatan
                $step3Class = '';
                $step3Icon = '3';
                if ($pengajuan->status_galasan == 'sent') {
                    $step3Class = $pengajuan->status_pembayaran == 'verified' ? 'done' : 'active';
                    $step3Icon = $pengajuan->status_pembayaran == 'verified' ? '<i class="bi bi-check-lg"></i>' : '3';
                }
            @endphp

            <div class="row g-4">
                {{-- KOLOM KIRI: Ringkasan Status --}}
                <div class="col-lg-4 animate-up" style="animation-delay: 0.1s;">
                    <div class="status-card-main h-100">
                        @if($pengajuan->status == 'approved')
                             <div class="status-icon-wrapper bg-status-success">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <h5 class="fw-bold text-success mb-1">Disetujui</h5>
                            <p class="text-muted small">Pengajuan Anda telah diterima.</p>
                        @elseif($pengajuan->status == 'rejected')
                            <div class="status-icon-wrapper bg-status-danger">
                                <i class="bi bi-x-circle-fill"></i>
                            </div>
                            <h5 class="fw-bold text-danger mb-1">Ditolak</h5>
                            <p class="text-muted small">Mohon periksa alasan penolakan.</p>
                        @else
                            <div class="status-icon-wrapper bg-status-pending">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <h5 class="fw-bold text-warning mb-1">Dalam Proses</h5>
                            <p class="text-muted small">Mohon lengkapi tahapan di sebelah kanan.</p>
                        @endif

                        <hr class="my-4">

                        <div class="text-start">
                            <div class="mb-3">
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Tanggal Pengajuan</small>
                                <span class="fw-bold text-dark">{{ $pengajuan->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Update Terakhir</small>
                                <span class="fw-bold text-dark">{{ $pengajuan->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: Timeline Proses --}}
                <div class="col-lg-8 animate-up" style="animation-delay: 0.2s;">
                    
                    {{-- STEP 1: ISI FORM --}}
                    <div class="step-card">
                        <div class="step-header {{ $step1Class }}">
                            <div class="step-number">{!! $step1Icon !!}</div>
                            <h6 class="mb-0 fw-bold">Lengkapi Biodata Pra Penelitian</h6>
                        </div>
                        <div class="step-body">
                            @if (!$praPenelitian)
                                <div class="alert alert-info border-0 d-flex align-items-center">
                                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                                    <div>Silakan isi formulir biodata dan judul penelitian terlebih dahulu.</div>
                                </div>
                                <a href="{{ route('pra-penelitian.create') }}" class="btn btn-maroon">
                                    <i class="bi bi-pencil-square me-2"></i> Isi Formulir
                                </a>
                            @elseif ($praPenelitian->status === 'Pending')
                                <div class="alert alert-warning border-0 d-flex align-items-center">
                                    <i class="bi bi-clock-history me-3 fs-4"></i>
                                    <div>
                                        <strong>Menunggu Verifikasi Admin</strong><br>
                                        Formulir Anda sedang ditinjau.
                                    </div>
                                </div>
                            @elseif ($praPenelitian->status === 'Rejected')
                                <div class="alert alert-danger border-0 d-flex align-items-center">
                                    <i class="bi bi-x-circle-fill me-3 fs-4"></i>
                                    <div>
                                        <strong>Formulir Ditolak</strong><br>
                                        Silakan perbaiki data Anda.
                                    </div>
                                </div>
                                <a href="{{ route('pra-penelitian.edit', $praPenelitian->id) }}" class="btn btn-outline-danger">
                                    <i class="bi bi-pencil-square me-2"></i> Edit Formulir
                                </a>
                            @else
                                <div class="alert alert-success border-0 d-flex align-items-center m-0 bg-opacity-10">
                                    <i class="bi bi-check-circle-fill me-3 fs-4 text-success"></i>
                                    <div>
                                        <strong>Biodata Terverifikasi</strong><br>
                                        <small class="text-muted">Judul: {{ $praPenelitian->judul }}</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- STEP 2: GALASAN --}}
                    @if ($praPenelitian && $praPenelitian->status === 'Approved')
                        <div class="step-card">
                            <div class="step-header {{ $step2Class }}">
                                <div class="step-number">{!! $step2Icon !!}</div>
                                <h6 class="mb-0 fw-bold">Surat Balasan & Invoice</h6>
                            </div>
                            <div class="step-body">
                                @if ($pengajuan->status_galasan === 'pending')
                                    <div class="text-center py-4 text-muted">
                                        <i class="bi bi-hourglass-top fs-2 opacity-50"></i>
                                        <p class="mb-0 mt-2">Menunggu Admin mengirimkan Surat Balasan.</p>
                                    </div>
                                @else
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            @if ($pengajuan->surat_balasan)
                                                <a href="{{ Storage::url($pengajuan->surat_balasan) }}" target="_blank" class="file-download-box text-decoration-none">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-file-earmark-pdf-fill text-danger fs-3 me-3"></i>
                                                        <div>
                                                            <div class="fw-bold text-dark">Surat Balasan</div>
                                                            <small class="text-muted">Klik untuk unduh</small>
                                                        </div>
                                                    </div>
                                                    <i class="bi bi-download text-secondary"></i>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            @if ($pengajuan->invoice)
                                                <a href="{{ Storage::url($pengajuan->invoice) }}" target="_blank" class="file-download-box text-decoration-none">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-receipt-cutoff text-warning fs-3 me-3"></i>
                                                        <div>
                                                            <div class="fw-bold text-dark">Invoice</div>
                                                            <small class="text-muted">Klik untuk unduh</small>
                                                        </div>
                                                    </div>
                                                    <i class="bi bi-download text-secondary"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- STEP 3: PEMBAYARAN & HASIL --}}
                    @if ($pengajuan->status_galasan === 'sent')
                        <div class="step-card">
                            <div class="step-header {{ $step3Class }}">
                                <div class="step-number">{!! $step3Icon !!}</div>
                                <h6 class="mb-0 fw-bold">Pembayaran & Penempatan</h6>
                            </div>
                            <div class="step-body">
                                @if ($pengajuan->status_pembayaran === 'pending')
                                    <p class="text-muted mb-3">Silakan lakukan pembayaran sesuai invoice, lalu upload buktinya di sini.</p>
                                    <form action="{{ route('pengajuan.upload-bukti', $pengajuan->id) }}" method="POST" enctype="multipart/form-data" class="p-3 bg-light rounded border">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Upload Bukti Transfer (PDF/JPG/PNG)</label>
                                            <input type="file" name="bukti_pembayaran" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                        </div>
                                        <button type="submit" class="btn btn-maroon w-100">
                                            <i class="bi bi-upload me-2"></i> Kirim Bukti Pembayaran
                                        </button>
                                    </form>

                                @elseif ($pengajuan->status_pembayaran === 'uploaded')
                                    <div class="alert alert-info border-0 d-flex align-items-center">
                                        <i class="bi bi-search me-3 fs-4"></i>
                                        <div>
                                            <strong>Bukti Terkirim</strong><br>
                                            Sedang diverifikasi oleh Admin.
                                        </div>
                                    </div>

                                @elseif ($pengajuan->status_pembayaran === 'verified')
                                    <div class="alert alert-success border-0 d-flex align-items-center mb-4">
                                        <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                        <div>
                                            <strong>Pembayaran Lunas!</strong><br>
                                            Selamat, proses administrasi Anda telah selesai.
                                        </div>
                                    </div>
                                    
                                    {{-- INFO CI --}}
                                    @if ($pengajuan->ci_nama)
                                        <div class="card border-0 shadow-sm" style="background: #f8f9fa;">
                                            <div class="card-body">
                                                <h6 class="fw-bold text-maroon mb-3"><i class="bi bi-person-badge-fill me-2"></i>Pembimbing Lapangan (CI)</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Nama</small>
                                                        <strong>{{ $pengajuan->ci_nama }}</strong>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Kontak</small>
                                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengajuan->ci_no_hp) }}" target="_blank" class="text-decoration-none fw-bold text-success">
                                                            <i class="bi bi-whatsapp me-1"></i> {{ $pengajuan->ci_no_hp }}
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Ruangan</small>
                                                        <strong>{{ $pengajuan->ruangan }}</strong>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Bidang</small>
                                                        <strong>{{ $pengajuan->ci_bidang }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            @endif
            
            {{-- (Optional: Tambahkan else untuk jenis Magang jika diperlukan) --}}

    </div>
@endsection