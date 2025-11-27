@extends('layouts.app')

@section('title', 'Pengajuan')
@section('page-title', 'Layanan Pengajuan')

@section('content')
    <style>
        :root {
            --custom-maroon: #7c1316;
            --custom-maroon-light: #a3191d;
            --custom-maroon-subtle: #fcf0f1;
            --text-dark: #2c3e50;
            --text-muted: #64748b;
            --card-radius: 20px;
            --transition: 0.3s ease;
        }

        /* --- Option Cards (Pilihan Menu) --- */
        .option-card {
            background: #fff;
            border: 2px solid transparent;
            border-radius: var(--card-radius);
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: default;
        }

        .option-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(124, 19, 22, 0.15);
            border-color: rgba(124, 19, 22, 0.1);
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background-color: var(--custom-maroon-subtle);
            color: var(--custom-maroon);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            transition: var(--transition);
        }

        .option-card:hover .icon-circle {
            background-color: var(--custom-maroon);
            color: white;
            transform: scale(1.1);
        }

        .option-title {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .option-desc {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        /* --- Status Card --- */
        .status-card {
            background: white;
            border-radius: var(--card-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border-top: 5px solid var(--custom-maroon);
            height: 100%;
        }

        .status-header {
            padding: 2rem 2rem 1rem;
            text-align: center;
        }

        .status-icon-large {
            font-size: 4rem;
            margin-bottom: 1rem;
            display: block;
        }

        .status-body {
            padding: 0 2rem 2rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        /* --- Badges --- */
        .badge-lg {
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .bg-pending { background-color: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; }
        .bg-approved { background-color: #f0fdf4; color: #15803d; border: 1px solid #dcfce7; }
        .bg-rejected { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fee2e2; }

        /* --- Buttons --- */
        .btn-maroon {
            background-color: var(--custom-maroon);
            color: white;
            border: none;
            padding: 0.7rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .btn-maroon:hover {
            background-color: var(--custom-maroon-light);
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 5px 15px rgba(124, 19, 22, 0.2);
        }

        /* Animation */
        .animate-up {
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

<div class="container py-4">

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show animate-up mb-4" role="alert"
            style="border-radius: 12px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.1);">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div>
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Alert Error --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show animate-up mb-4" role="alert"
            style="border-radius: 12px;">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                <div>
                    <strong>Gagal!</strong> {{ session('error') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="text-center mb-5 animate-up">
        <h2 class="fw-bold" style="color: var(--text-dark);">Dashboard Pengajuan</h2>
        <p class="text-muted">Kelola pengajuan Pra-Penelitian dan Magang Anda di sini.</p>
    </div>

    <div class="row justify-content-center g-4">

        {{-- ========================== KOLOM 1: PRA PENELITIAN ========================== --}}
        <div class="col-md-6 col-lg-5 animate-up" style="animation-delay: 0.1s;">

            @if ($pra)
                {{-- JIKA SUDAH ADA DATA PRA PENELITIAN -> TAMPILKAN STATUS --}}
                <div class="status-card">
                    <div class="status-header text-center">
                        <h5 class="fw-bold mb-3">Pra Penelitian</h5>

                        @if ($pra->status === 'pending')
                            <div class="status-icon-large text-warning mb-2"><i class="bi bi-hourglass-split"></i></div>
                            <span class="badge-lg bg-pending">Menunggu Persetujuan</span>
                        @elseif ($pra->status === 'approved')
                            <div class="status-icon-large text-success mb-2"><i class="bi bi-check-circle-fill"></i></div>
                            <span class="badge-lg bg-approved">Disetujui</span>
                        @elseif ($pra->status === 'rejected')
                            <div class="status-icon-large text-danger mb-2"><i class="bi bi-x-circle-fill"></i></div>
                            <span class="badge-lg bg-rejected">Ditolak</span>
                        @endif
                    </div>

                    <div class="status-body mt-3">
                        <div class="detail-row">
                            <span class="text-muted small">Tanggal Pengajuan</span>
                            <span class="fw-bold small">{{ $pra->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="text-muted small">Update Terakhir</span>
                            <span class="fw-bold small">{{ $pra->updated_at->diffForHumans() }}</span>
                        </div>

                        @if ($pra->status === 'rejected')
                            <div class="alert alert-danger small py-2 mt-3">
                                <i class="bi bi-info-circle me-1"></i> Pengajuan Anda ditolak. Silakan ajukan ulang.
                            </div>
                            <form action="{{ route('pengajuan.pra') }}" method="POST" class="w-100 mt-3">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100 btn-sm"
                                    onclick="return confirm('Ajukan Ulang Pra Penelitian?')">
                                    <i class="bi bi-arrow-repeat me-1"></i> Ajukan Ulang
                                </button>
                            </form>
                        @elseif ($pra->status === 'approved')
                            
                            {{-- CEK STATUS FORM DETAIL --}}
                            @php
                                $praPenelitian = App\Models\PraPenelitian::where('user_id', auth()->id())->first();
                            @endphp

                            @if (!$praPenelitian)
                                {{-- CASE A: Belum isi form detail --}}
                                <div class="alert alert-info small py-2 mt-3">
                                    <i class="bi bi-info-circle me-1"></i> Langkah selanjutnya: Isi biodata lengkap.
                                </div>
                                <div class="text-center mt-2">
                                    <a href="{{ route('pra-penelitian.create') }}" class="btn btn-maroon btn-sm w-100 shadow-sm">
                                        <i class="bi bi-pencil-square me-1"></i> Isi Form Pra Penelitian
                                    </a>
                                </div>

                            @elseif ($praPenelitian->status === 'Pending')
                                {{-- CASE B: Sudah isi, menunggu review admin --}}
                                <div class="alert alert-warning small py-2 mt-3">
                                    <i class="bi bi-clock-history me-1"></i> Biodata sedang ditinjau oleh Admin.
                                </div>
                                <div class="text-center">
                                    <small class="text-muted fst-italic">Mohon menunggu validasi surat pengantar.</small>
                                </div>

                            @elseif ($praPenelitian->status === 'Rejected')
                                {{-- CASE C: Form ditolak --}}
                                <div class="alert alert-danger small py-2 mt-3">
                                    <i class="bi bi-x-circle me-1"></i> Data Anda ditolak. Silakan perbaiki.
                                </div>
                                <div class="text-center mt-2">
                                    <a href="{{ route('pra-penelitian.edit', $praPenelitian->id) }}" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="bi bi-pencil-square me-1"></i> Perbaiki Data
                                    </a>
                                </div>

                            @elseif ($praPenelitian->status === 'Approved')
                                {{-- CASE D: Form disetujui, cek Galasan & Pembayaran --}}
                                
                                @if ($pra->status_galasan === 'pending')
                                    {{-- D.1 Menunggu Admin Kirim Surat --}}
                                    <div class="alert alert-info small py-2 mt-3">
                                        <i class="bi bi-hourglass-split me-1"></i> Menunggu Admin mengirim Surat Balasan & Invoice.
                                    </div>

                                @elseif ($pra->status_galasan === 'sent')
                                    {{-- D.2 Surat Ada, Cek Pembayaran --}}
                                    <div class="alert alert-success small py-2 mt-3 border-0 bg-success bg-opacity-10 text-success">
                                        <i class="bi bi-envelope-check-fill me-1"></i> Surat Balasan diterima!
                                    </div>
                                    
                                    <div class="d-flex gap-2 mb-3">
                                        @if ($pra->surat_balasan)
                                            <a href="{{ Storage::url($pra->surat_balasan) }}" target="_blank" class="btn btn-sm btn-outline-primary flex-fill">
                                                <i class="bi bi-file-earmark-pdf me-1"></i> Surat
                                            </a>
                                        @endif
                                        @if ($pra->invoice)
                                            <a href="{{ Storage::url($pra->invoice) }}" target="_blank" class="btn btn-sm btn-outline-warning flex-fill text-dark">
                                                <i class="bi bi-receipt me-1"></i> Invoice
                                            </a>
                                        @endif
                                    </div>

                                    {{-- Status Pembayaran --}}
                                    @if ($pra->status_pembayaran === 'pending')
                                        <form action="{{ route('pengajuan.upload-bukti', $pra->id) }}" method="POST" enctype="multipart/form-data" class="p-3 bg-light rounded border">
                                            @csrf
                                            <label class="form-label small fw-bold mb-2">Upload Bukti Pembayaran</label>
                                            <input type="file" name="bukti_pembayaran" class="form-control form-control-sm mb-2" accept=".pdf,.jpg,.jpeg,.png" required>
                                            <button type="submit" class="btn btn-maroon btn-sm w-100">
                                                <i class="bi bi-upload me-1"></i> Kirim Bukti
                                            </button>
                                        </form>

                                    @elseif ($pra->status_pembayaran === 'uploaded')
                                        <div class="alert alert-warning small py-2 mb-0">
                                            <i class="bi bi-clock me-1"></i> Pembayaran sedang diverifikasi.
                                        </div>

                                    @elseif ($pra->status_pembayaran === 'verified')
                                        <div class="alert alert-success small py-2 mb-3 border-0 bg-success text-white">
                                            <i class="bi bi-check-all me-1"></i> <strong>LUNAS & TERVERIFIKASI</strong>
                                        </div>

                                        {{-- INFO PEMBIMBING (CI) --}}
                                        @if ($pra->ci_nama)
                                            <div class="card border-0 shadow-sm bg-light">
                                                <div class="card-body p-3">
                                                    <h6 class="fw-bold mb-2 text-dark border-bottom pb-2">Data Pembimbing</h6>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="small text-muted">Nama:</span>
                                                        <span class="small fw-bold">{{ $pra->ci_nama }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="small text-muted">Kontak:</span>
                                                        <a href="tel:{{ $pra->ci_no_hp }}" class="small fw-bold text-decoration-none">{{ $pra->ci_no_hp }}</a>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="small text-muted">Ruangan:</span>
                                                        <span class="small fw-bold text-custom-maroon">{{ $pra->ruangan }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 text-center">
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pra->ci_no_hp) }}" target="_blank" class="btn btn-success btn-sm w-100">
                                                    <i class="bi bi-whatsapp me-1"></i> Hubungi Pembimbing
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            @endif

                        @else
                            <div class="alert alert-light text-center small text-muted mb-0">
                                Mohon menunggu verifikasi admin.
                            </div>
                        @endif
                    </div>
                </div>
            @else
                {{-- JIKA BELUM ADA DATA -> TAMPILKAN MENU PENGAJUAN --}}
                <div class="option-card">
                    <div class="icon-circle align-self-center mb-3">
                        <i class="bi bi-journal-richtext"></i>
                    </div>
                    <h4 class="option-title text-center">Pra Penelitian</h4>
                    <p class="option-desc text-center text-muted mb-4">
                        Ajukan permohonan untuk melakukan observasi, pengambilan data awal, atau survei pendahuluan.
                    </p>
                    <form action="{{ route('pengajuan.pra') }}" method="POST" class="w-100 mt-auto">
                        @csrf
                        <button type="submit" class="btn btn-maroon w-100"
                            onclick="return confirm('Ajukan Pra Penelitian?')">
                            Pilih Layanan <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- ========================== KOLOM 2: MAGANG ========================== --}}
        <div class="col-md-6 col-lg-5 animate-up" style="animation-delay: 0.2s;">

            @if ($magang)
                <div class="status-card">
                    <div class="status-header text-center">
                        <h5 class="fw-bold mb-3">Magang / PKL</h5>

                        @if ($magang->status === 'pending')
                            <div class="status-icon-large text-warning mb-2"><i class="bi bi-hourglass-split"></i></div>
                            <span class="badge-lg bg-pending">Menunggu Persetujuan</span>
                        @elseif ($magang->status === 'approved')
                            <div class="status-icon-large text-success mb-2"><i class="bi bi-check-circle-fill"></i></div>
                            <span class="badge-lg bg-approved">Disetujui</span>
                        @elseif ($magang->status === 'rejected')
                            <div class="status-icon-large text-danger mb-2"><i class="bi bi-x-circle-fill"></i></div>
                            <span class="badge-lg bg-rejected">Ditolak</span>
                        @endif
                    </div>

                    <div class="status-body mt-3">
                        <div class="detail-row">
                            <span class="text-muted small">Tanggal Pengajuan</span>
                            <span class="fw-bold small">{{ $magang->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="text-muted small">Update Terakhir</span>
                            <span class="fw-bold small">{{ $magang->updated_at->diffForHumans() }}</span>
                        </div>

                        @if ($magang->status === 'rejected')
                            <div class="alert alert-danger small py-2 mt-3">
                                <i class="bi bi-info-circle me-1"></i> Pengajuan Anda ditolak.
                            </div>
                            <form action="{{ route('pengajuan.magang') }}" method="POST" class="w-100 mt-3">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100 btn-sm"
                                    onclick="return confirm('Ajukan Ulang Magang?')">
                                    <i class="bi bi-arrow-repeat me-1"></i> Ajukan Ulang
                                </button>
                            </form>
                        @elseif ($magang->status === 'approved')
                            <div class="alert alert-success small py-2 mt-3 border-0 bg-success bg-opacity-10 text-success">
                                <i class="bi bi-check-lg me-1"></i> Pengajuan diterima.
                            </div>
                            <div class="text-center mt-2">
                                <a href="{{ route('mahasiswa.create') }}" class="btn btn-maroon btn-sm w-100 shadow-sm">
                                    Lengkapi Biodata Magang <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        @else
                            <div class="alert alert-light text-center small text-muted mb-0 mt-3">
                                Mohon menunggu verifikasi admin.
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="option-card">
                    <div class="icon-circle align-self-center mb-3">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <h4 class="option-title text-center">Magang / PKL</h4>
                    <p class="option-desc text-center text-muted mb-4">
                        Ajukan permohonan resmi untuk pelaksanaan Praktik Kerja Lapangan (PKL) atau Magang.
                    </p>
                    <form action="{{ route('pengajuan.magang') }}" method="POST" class="w-100 mt-auto">
                        @csrf
                        <button type="submit" class="btn btn-maroon w-100"
                            onclick="return confirm('Ajukan Magang?')">
                            Pilih Layanan <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection