@extends('layouts.app')

@section('title', 'Detail Presentasi')
@section('page-title', 'Detail Presentasi')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('admin.presentasi.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Info Mahasiswa --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-maroon text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Informasi</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Nama Mahasiswa</small>
                        <strong>{{ $presentasi->user->name }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Email</small>
                        <strong>{{ $presentasi->user->email }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Judul Penelitian</small>
                        <strong>{{ $presentasi->praPenelitian->judul }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Tanggal Presentasi</small>
                        <strong>{{ $presentasi->tanggal_presentasi->format('d F Y') }}</strong><br>
                        <small>{{ $presentasi->waktu_mulai }} - {{ $presentasi->waktu_selesai }}</small>
                    </div>
                    <div>
                        <small class="text-muted d-block">Tempat</small>
                        <strong>{{ $presentasi->tempat }}</strong>
                    </div>
                </div>
            </div>

            {{-- Link CI --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-link-45deg me-2"></i>Link CI</h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-2">Link untuk penilaian CI:</p>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="linkCI" value="{{ route('ci.penilaian', $presentasi->id) }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyLink()">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail & Actions --}}
        <div class="col-lg-8">
            {{-- File PPT --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-slides me-2"></i>File Presentasi (PPT)</h5>
                </div>
                <div class="card-body">
                    @if ($presentasi->file_ppt)
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i> File sudah diupload
                        </div>
                        <a href="{{ Storage::url($presentasi->file_ppt) }}" target="_blank" class="btn btn-primary">
                            <i class="bi bi-download me-1"></i> Download File PPT
                        </a>
                        <small class="d-block mt-2 text-muted">
                            Diupload: {{ $presentasi->uploaded_at->format('d M Y H:i') }}
                        </small>
                    @else
                        <div class="alert alert-warning">
                            <i class="bi bi-clock-history me-2"></i> Menunggu mahasiswa upload file
                        </div>
                    @endif
                </div>
            </div>

            {{-- Penilaian CI --}}
            @if ($presentasi->nilai)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-clipboard-check me-2"></i>Hasil Penilaian CI</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-{{ $presentasi->nilai == 'A' || $presentasi->nilai == 'B' ? 'success' : ($presentasi->nilai == 'C' ? 'warning' : 'danger') }}">
                            <h4 class="mb-0"><i class="bi bi-trophy-fill me-2"></i>Nilai: {{ $presentasi->nilai }}</h4>
                        </div>

                        @if ($presentasi->hasil_penilaian)
                            <h6 class="fw-bold mb-3">Detail Penilaian:</h6>
                            @foreach ($presentasi->hasil_penilaian as $index => $item)
                                <div class="card mb-2">
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold mb-1">{{ $index + 1 }}. {{ $item['judul'] }}</h6>
                                        <p class="mb-0 small">{{ $item['keterangan'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <small class="text-muted">Dinilai: {{ $presentasi->dinilai_at->format('d M Y H:i') }}</small>
                    </div>
                </div>
            @endif

            {{-- File Laporan & Review --}}
            @if (in_array($presentasi->nilai, ['A', 'B']))
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Laporan Akhir</h5>
                    </div>
                    <div class="card-body">
                        @if ($presentasi->file_laporan)
                            <div class="alert alert-info">
                                <i class="bi bi-check-circle me-2"></i> Laporan sudah diupload
                            </div>
                            <a href="{{ Storage::url($presentasi->file_laporan) }}" target="_blank" class="btn btn-primary mb-3">
                                <i class="bi bi-download me-1"></i> Download Laporan
                            </a>
                            <small class="d-block mb-3 text-muted">
                                Diupload: {{ $presentasi->laporan_uploaded_at->format('d M Y H:i') }}
                            </small>

                            @if ($presentasi->status_laporan == 'pending')
                                <hr>
                                <h6 class="fw-bold mb-3">Review Laporan:</h6>
                                <form action="{{ route('admin.presentasi.review-laporan', $presentasi->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="">Pilih Status</option>
                                            <option value="approved">Setujui (Selesai)</option>
                                            <option value="revisi">Revisi</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Keterangan</label>
                                        <textarea name="keterangan" rows="3" class="form-control" placeholder="Catatan untuk mahasiswa"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-maroon" onclick="return confirm('Submit review laporan?')">
                                        <i class="bi bi-send me-1"></i> Submit Review
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-{{ $presentasi->status_laporan == 'approved' ? 'success' : 'warning' }}">
                                    <i class="bi bi-{{ $presentasi->status_laporan == 'approved' ? 'check-circle-fill' : 'exclamation-triangle-fill' }} me-2"></i>
                                    Status: <strong>{{ ucfirst($presentasi->status_laporan) }}</strong>
                                    @if ($presentasi->keterangan_review)
                                        <br><small>{{ $presentasi->keterangan_review }}</small>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-clock-history me-2"></i> Menunggu mahasiswa upload laporan
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Dokumen Final --}}
            @if ($presentasi->status_final == 'selesai')
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-check me-2"></i>Dokumen Final</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            @if ($presentasi->surat_selesai)
                                <a href="{{ Storage::url($presentasi->surat_selesai) }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="bi bi-file-pdf me-1"></i> Surat Selesai
                                </a>
                            @endif
                            @if ($presentasi->sertifikat)
                                <a href="{{ Storage::url($presentasi->sertifikat) }}" target="_blank" class="btn btn-outline-success">
                                    <i class="bi bi-award me-1"></i> Sertifikat
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function copyLink() {
    const link = document.getElementById('linkCI');
    link.select();
    link.setSelectionRange(0, 99999);
    document.execCommand('copy');
    alert('Link berhasil dicopy!');
}
</script>
@endsection