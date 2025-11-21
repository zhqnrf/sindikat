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
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .ftr {
            text-align: center;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .detail-value {
            font-weight: 700;
            color: var(--text-dark);
            text-transform: capitalize;
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

        .bg-pending {
            background-color: #fff7ed;
            color: #c2410c;
            border: 1px solid #ffedd5;
        }

        .bg-approved {
            background-color: #f0fdf4;
            color: #15803d;
            border: 1px solid #dcfce7;
        }

        .bg-rejected {
            background-color: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fee2e2;
        }

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
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-up" role="alert"
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

        @if (!$pengajuan)
            {{-- TAMPILAN 1: BELUM ADA PENGAJUAN (MENU PILIHAN) --}}
            <div class="text-center mb-5 animate-up">
                <h2 class="fw-bold" style="color: var(--text-dark);">Mulai Pengajuan Baru</h2>
                <p class="text-muted">Silakan pilih jenis layanan yang Anda butuhkan di bawah ini.</p>
            </div>

            <div class="row justify-content-center g-4">
                <!-- Card Pra Penelitian -->
                <div class="col-md-5 col-lg-4 animate-up" style="animation-delay: 0.1s;">
                    <div class="option-card">
                        <div class="icon-circle">
                            <i class="bi bi-journal-richtext"></i>
                        </div>
                        <h4 class="option-title">Pra Penelitian</h4>
                        <p class="option-desc">
                            Ajukan permohonan untuk melakukan observasi, pengambilan data awal, atau survei pendahuluan.
                        </p>
                        <form action="{{ route('pengajuan.pra') }}" method="POST" class="w-100 mt-auto">
                            @csrf
                            <button type="submit" class="btn btn-maroon"
                                onclick="return confirm('Ajukan Pra Penelitian?')">
                                Pilih Layanan <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Card Magang -->
                <div class="col-md-5 col-lg-4 animate-up" style="animation-delay: 0.2s;">
                    <div class="option-card">
                        <div class="icon-circle">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <h4 class="option-title">Magang / PKL</h4>
                        <p class="option-desc">
                            Ajukan permohonan resmi untuk pelaksanaan Praktik Kerja Lapangan (PKL) atau Magang.
                        </p>
                        <form action="{{ route('pengajuan.magang') }}" method="POST" class="w-100 mt-auto">
                            @csrf
                            <button type="submit" class="btn btn-maroon" onclick="return confirm('Ajukan Magang?')">
                                Pilih Layanan <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            {{-- TAMPILAN 2: SUDAH ADA PENGAJUAN (STATUS TRACKER) --}}
            <div class="row justify-content-center animate-up">
                <div class="col-md-6 col-lg-5">
                    <div class="status-card">
                        <div class="status-header">
                            @if ($pengajuan->status === 'pending')
                                <div class="status-icon-large text-warning">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                                <span class="badge-lg bg-pending">Menunggu Persetujuan</span>
                            @elseif ($pengajuan->status === 'approved')
                                <div class="status-icon-large text-success">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <span class="badge-lg bg-approved">Disetujui</span>
                            @elseif ($pengajuan->status === 'rejected')
                                <div class="status-icon-large text-danger">
                                    <i class="bi bi-x-circle-fill"></i>
                                </div>
                                <span class="badge-lg bg-rejected">Ditolak</span>
                            @endif

                            <h4 class="fw-bold mt-3 mb-1">Status Pengajuan Anda</h4>
                            <p class="text-muted small mb-0">Pantau terus status terbaru di halaman ini.</p>
                        </div>

                        <div class="status-body">
                            <div class="detail-row">
                                <span class="detail-label">Jenis Pengajuan</span>
                                <span class="detail-value" style="color: var(--custom-maroon);">
                                    {{ ucwords(str_replace('_', ' ', $pengajuan->jenis)) }}
                                </span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Tanggal Pengajuan</span>
                                <span class="detail-value">{{ $pengajuan->created_at->format('d F Y') }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Terakhir Diupdate</span>
                                <span class="detail-value">{{ $pengajuan->updated_at->diffForHumans() }}</span>
                            </div>
                            <div class="ftr">
                                <span class="detail-value">Silahkan Akses Menu Yang Tersedia Di Sidebar</span>
                            </div>

                            @if ($pengajuan->status === 'pending')
                                <div class="alert alert-warning mt-4 mb-0 text-center small" role="alert">
                                    <i class="bi bi-info-circle me-1"></i> Mohon menunggu konfirmasi dari Admin.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
