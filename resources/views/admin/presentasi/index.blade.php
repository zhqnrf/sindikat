@extends('layouts.app')

@section('title', 'Daftar Presentasi')
@section('page-title', 'Daftar Presentasi')

@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="fw-bold mb-0"><i class="bi bi-list-check me-2"></i>Daftar Semua Presentasi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Judul Penelitian</th>
                            <th>Tanggal Presentasi</th>
                            <th>Status PPT</th>
                            <th>Nilai</th>
                            <th>Status Laporan</th>
                            <th>Status Final</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($presentasi as $p)
                            <tr>
                                <td>{{ $loop->iteration + ($presentasi->currentPage() - 1) * $presentasi->perPage() }}</td>
                                <td>
                                    <strong>{{ $p->user->name }}</strong><br>
                                    <small class="text-muted">{{ $p->user->email }}</small>
                                </td>
                                <td>{{ $p->praPenelitian->judul ?? '-' }}</td>
                                <td>
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $p->tanggal_presentasi->format('d M Y') }}<br>
                                    <small class="text-muted">{{ $p->waktu_mulai }} - {{ $p->waktu_selesai }}</small>
                                </td>
                                <td>
                                    @if ($p->file_ppt)
                                        <span class="badge bg-success">Sudah Upload</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum Upload</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($p->nilai)
                                        <span class="badge bg-{{ $p->nilai == 'A' || $p->nilai == 'B' ? 'success' : ($p->nilai == 'C' ? 'warning' : 'danger') }}">
                                            Nilai {{ $p->nilai }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($p->file_laporan)
                                        @if ($p->status_laporan == 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif ($p->status_laporan == 'revisi')
                                            <span class="badge bg-warning text-dark">Revisi</span>
                                        @else
                                            <span class="badge bg-info">Pending Review</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($p->status_final == 'selesai')
                                        <span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Selesai</span>
                                    @elseif ($p->status_final == 'ditolak')
                                        <span class="badge bg-danger"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">Proses</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.presentasi.detail', $p->id) }}" class="btn btn-outline-primary" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if ($p->file_ppt)
                                            <a href="{{ Storage::url($p->file_ppt) }}" target="_blank" class="btn btn-outline-success" title="Lihat PPT">
                                                <i class="bi bi-file-earmark-slides"></i>
                                            </a>
                                        @endif
                                        @if ($p->file_laporan)
                                            <a href="{{ Storage::url($p->file_laporan) }}" target="_blank" class="btn btn-outline-info" title="Lihat Laporan">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
                                    <p class="text-muted mt-3">Belum ada presentasi</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $presentasi->links() }}
        </div>
    </div>
</div>
@endsection