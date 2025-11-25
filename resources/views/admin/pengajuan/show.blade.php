@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Back Button --}}
    <div class="mb-4">
        <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Header --}}
    <div class="page-header-wrapper animate-up mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--custom-maroon);">Detail Pengajuan</h4>
            <small class="text-muted">Kelola galasan dan verifikasi pembayaran</small>
        </div>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- Informasi Pengajuan --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-maroon text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Informasi Pengguna</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Nama</small>
                        <strong>{{ $pengajuan->user->name }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Email</small>
                        <strong>{{ $pengajuan->user->email }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Universitas</small>
                        <strong>{{ $pengajuan->user->mou->nama_universitas ?? '-' }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Jenis Pengajuan</small>
                        <span class="badge bg-primary">
                            {{ ucwords(str_replace('_', ' ', $pengajuan->jenis)) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Status</small>
                        @if ($pengajuan->status === 'approved')
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($pengajuan->status) }}</span>
                        @endif
                    </div>

                    <div>
                        <small class="text-muted d-block">Tanggal Pengajuan</small>
                        <strong>{{ $pengajuan->created_at->format('d M Y H:i') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Status Form Pra Penelitian -->
<div class="col-lg-12 mb-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="bi bi-clipboard-check me-2"></i>Status Form Pra Penelitian
            </h5>
        </div>
        <div class="card-body">
            @php
                $praPenelitian = App\Models\PraPenelitian::where('user_id', $pengajuan->user_id)->first();
            @endphp

            @if (!$praPenelitian)
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Mahasiswa belum mengisi form pra penelitian
                </div>
            @else
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Judul Penelitian</small>
                        <strong>{{ $praPenelitian->judul }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Jenis Penelitian</small>
                        <strong>{{ $praPenelitian->jenis_penelitian }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Status Form</small>
                        @if ($praPenelitian->status === 'Pending')
                            <span class="badge bg-warning text-dark">Menunggu Approval</span>
                        @elseif ($praPenelitian->status === 'Approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif ($praPenelitian->status === 'Rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Surat Pengantar</small>
                        <a href="{{ Storage::url($praPenelitian->file_surat_pengantar) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-file-pdf me-1"></i> Lihat Surat
                        </a>
                    </div>
                </div>

                @if ($praPenelitian->status === 'Pending')
                    <hr>
                    <div class="d-flex gap-2">
                        <form action="{{ route('pra-penelitian.approve', $praPenelitian->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Approve form pra penelitian?')">
                                <i class="bi bi-check-lg me-1"></i> Approve Form
                            </button>
                        </form>
                        <form action="{{ route('pra-penelitian.reject', $praPenelitian->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Reject form pra penelitian?')">
                                <i class="bi bi-x-lg me-1"></i> Reject Form
                            </button>
                        </form>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

        {{-- Area Proses Galasan + Pembayaran --}}
        <div class="col-lg-8">

            {{-- STEP 1: Kirim Galasan --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header"
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <h5 class="mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i> Step 1: Kirim Galasan (Surat & Invoice)
                    </h5>
                </div>

                <div class="card-body">
                    @if ($pengajuan->status_galasan === 'pending')

                        <form action="{{ route('admin.pengajuan.kirim-galasan', $pengajuan->id) }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Upload Surat Balasan (PDF)</label>
                                <input type="file" name="surat_balasan" class="form-control" accept=".pdf" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Upload Invoice (PDF)</label>
                                <input type="file" name="invoice" class="form-control" accept=".pdf" required>
                            </div>

                            <button class="btn btn-primary"
                                    onclick="return confirm('Kirim galasan ke mahasiswa?')">
                                <i class="bi bi-send me-2"></i>Kirim Galasan
                            </button>
                        </form>

                    @else
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-2"></i> Galasan sudah dikirim
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ Storage::url($pengajuan->surat_balasan) }}" target="_blank"
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-file-pdf me-1"></i> Lihat Surat
                            </a>

                            <a href="{{ Storage::url($pengajuan->invoice) }}" target="_blank"
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-receipt me-1"></i> Lihat Invoice
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- STEP 2: Verifikasi Pembayaran --}}
            @if ($pengajuan->status_galasan === 'sent')
                <div class="card border-0 shadow-sm">
                    <div class="card-header"
                         style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                        <h5 class="mb-0">
                            <i class="bi bi-currency-dollar me-2"></i> Step 2: Verifikasi Pembayaran
                        </h5>
                    </div>

                    <div class="card-body">

                        {{-- Bukti Pembayaran --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Bukti Pembayaran</label>
                            <a href="{{ Storage::url($pengajuan->bukti_pembayaran) }}" target="_blank"
                               class="btn btn-outline-success">
                                <i class="bi bi-file-earmark-image me-1"></i> Lihat Bukti Pembayaran
                            </a>
                        </div>

                        @if ($pengajuan->status_pembayaran !== 'verified')

                            {{-- Form Approve --}}
                            <form action="{{ route('admin.pengajuan.approve-pembayaran', $pengajuan->id) }}"
                                  method="POST">
                                @csrf
                                <div class="row g-3 mb-3">

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Nama Pembimbing (CI)</label>
                                        <input type="text" name="ci_nama" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">No. HP CI</label>
                                        <input type="text" name="ci_no_hp" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Bidang CI</label>
                                        <input type="text" name="ci_bidang" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Ruangan</label>
                                        <input type="text" name="ruangan" class="form-control" required>
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-success"
                                        onclick="return confirm('Verifikasi pembayaran dan assign CI/Ruangan?')">
                                    <i class="bi bi-check-circle me-2"></i> Verifikasi & Assign CI
                                </button>
                            </form>

                        @else
                            {{-- Sudah Diverifikasi --}}
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill me-2"></i> Pembayaran sudah diverifikasi
                            </div>

                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Informasi CI & Ruangan</h6>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Nama Pembimbing</small>
                                            <strong>{{ $pengajuan->ci_nama }}</strong>
                                        </div>

                                        <div class="col-md-6">
                                            <small class="text-muted d-block">No. HP</small>
                                            <strong>{{ $pengajuan->ci_no_hp }}</strong>
                                        </div>

                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Bidang</small>
                                            <strong>{{ $pengajuan->ci_bidang }}</strong>
                                        </div>

                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Ruangan</small>
                                            <strong>{{ $pengajuan->ruangan }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <a href="{{ Storage::url($pengajuan->bukti_pembayaran) }}" target="_blank"
                                   class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-file-earmark-image me-1"></i> Lihat Bukti Pembayaran
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
