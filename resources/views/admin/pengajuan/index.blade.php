@extends('layouts.app')

@section('title', 'Approval Pengajuan')
@section('page-title', 'Data Pengajuan')

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

        /* --- Table Card --- */
        .custom-table-card {
            background: #fff;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow-soft);
            overflow: hidden;
            border: none;
        }

        .table thead th {
            background-color: var(--custom-maroon);
            color: white;
            border: none;
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #475569;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-hover tbody tr:hover {
            background-color: #fff5f6;
        }

        /* --- Status Badges --- */
        .badge-status {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-pending { background-color: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; }
        .status-approved { background-color: #f0fdf4; color: #15803d; border: 1px solid #dcfce7; }
        .status-rejected { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fee2e2; }

        /* --- Action Buttons --- */
        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            border: none;
            color: white;
        }

        .btn-approve {
            background-color: #10b981; /* Green */
            box-shadow: 0 2px 5px rgba(16, 185, 129, 0.3);
        }
        .btn-approve:hover { background-color: #059669; transform: translateY(-2px); }

        .btn-reject {
            background-color: #ef4444; /* Red */
            box-shadow: 0 2px 5px rgba(239, 68, 68, 0.3);
        }
        .btn-reject:hover { background-color: #dc2626; transform: translateY(-2px); }

        /* --- Animation --- */
        .animate-up {
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            opacity: 0; transform: translateY(20px);
        }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
    </style>

<!-- Header Section -->
<div class="page-header-wrapper animate-up">
    <div>
        <h4 class="fw-bold mb-1" style="color: var(--custom-maroon);">Daftar Pengajuan</h4>
        <small class="text-muted">Kelola persetujuan pengajuan dari pengguna.</small>
    </div>
</div>

<!-- Alert Messages -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show animate-up" role="alert" style="border-radius: 12px;">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show animate-up" role="alert" style="border-radius: 12px;">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Table Section -->
<div class="custom-table-card animate-up" style="animation-delay: 0.1s;">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th>Nama Pengguna</th>
                    <th>Asal Universitas</th>
                    <th>Jenis Pengajuan</th>
                    <th>Tanggal</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Status Galasan</th>
                    <th class="text-center">Status Pembayaran</th>
                    <th class="text-center" width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $p)
                    <tr>
                        <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-dark">{{ $p->user->name ?? 'User Terhapus' }}</span>
                                <small class="text-muted">{{ $p->user->email ?? '-' }}</small>
                            </div>
                        </td>
                        <td>{{ $p->user->mou ? $p->user->mou->nama_universitas : '-' }}</td>
                        <td>
                            <span class="fw-medium text-dark">{{ ucwords(str_replace('_', ' ', $p->jenis)) }}</span>
                        </td>
                        <td>
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i> {{ $p->created_at->format('d M Y') }}
                            </small>
                        </td>
                        <td class="text-center">
                            @if ($p->status === 'pending')
                                <span class="badge-status status-pending">
                                    <i class="bi bi-hourglass-split"></i> Pending
                                </span>
                            @elseif ($p->status === 'approved')
                                <span class="badge-status status-approved">
                                    <i class="bi bi-check-circle-fill"></i> Disetujui
                                </span>
                            @elseif ($p->status === 'rejected')
                                <span class="badge-status status-rejected">
                                    <i class="bi bi-x-circle-fill"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($p->status === 'approved')
                                @if ($p->status_galasan === 'pending')
                                    <span class="badge bg-secondary">Belum Kirim</span>
                                @else
                                    <span class="badge bg-info">Sudah Kirim</span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($p->status === 'approved' && $p->status_galasan === 'sent')
                                @if ($p->status_pembayaran === 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu Upload</span>
                                @elseif ($p->status_pembayaran === 'uploaded')
                                    <span class="badge bg-primary">Perlu Verifikasi</span>
                                @elseif ($p->status_pembayaran === 'verified')
                                    <span class="badge bg-success">Terverifikasi</span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($p->status === 'pending')
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Approve --}}
                                    <form action="{{ route('admin.pengajuan.approve', $p->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action btn-approve" title="Setujui" onclick="return confirm('Yakin ingin menyetujui pengajuan ini?')">
                                            <i class="bi bi-check-lg fs-5"></i>
                                        </button>
                                    </form>

                                    {{-- Tombol Reject --}}
                                    <form action="{{ route('admin.pengajuan.reject', $p->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action btn-reject" title="Tolak" onclick="return confirm('Yakin ingin menolak pengajuan ini?')">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            @elseif ($p->status === 'approved')
                                <a href="{{ route('admin.pengajuan.show', $p->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> Lihat Detail
                                </a>
                            @else
                                <span class="text-muted small fst-italic">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-inbox display-4 text-muted mb-3 opacity-50"></i>
                                <h5 class="text-muted fw-bold">Tidak ada pengajuan baru</h5>
                                <p class="text-muted small">Daftar pengajuan akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection