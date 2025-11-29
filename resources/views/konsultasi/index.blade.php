@extends('layouts.app')

@section('title', 'Konsultasi Penelitian')
@section('page-title', 'Konsultasi dengan CI')

{{-- Tambahkan CSS Summernote di head --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    .note-editor.note-frame.is-invalid {
        border-color: #dc3545;
    }
    .hasil-konsul {
        line-height: 1.8;
    }
    .hasil-konsul p {
        margin-bottom: 0.5rem;
    }
    .hasil-konsul ul, .hasil-konsul ol {
        margin-left: 1.5rem;
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@section('content')
    <div class="container py-4">
        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('pengajuan.detail', 'pra_penelitian') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
            </a>
        </div>

        <div class="row g-4">
            {{-- Info CI Card --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-maroon text-white">
                        <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Pembimbing (CI)</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Nama</small>
                            <strong>{{ $pengajuan->ci_nama }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">No. HP</small>
                            <a href="tel:{{ $pengajuan->ci_no_hp }}" class="text-decoration-none fw-bold">
                                <i class="bi bi-telephone-fill me-1"></i>{{ $pengajuan->ci_no_hp }}
                            </a>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Bidang</small>
                            <strong>{{ $pengajuan->ci_bidang }}</strong>
                        </div>
                        <div>
                            <small class="text-muted d-block">Ruangan</small>
                            <strong class="text-maroon">{{ $pengajuan->ruangan }}</strong>
                        </div>

                        <hr>

                        <div class="alert alert-info small mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            <strong>Minimal konsultasi: {{ $minKonsul }}x</strong><br>
                            Total konsultasi Anda: <strong class="{{ $totalKonsul >= $minKonsul ? 'text-success' : 'text-danger' }}">{{ $totalKonsul }}x</strong>
                            @if ($totalKonsul < $minKonsul)
                                <br><small class="text-danger">Kurang {{ $minKonsul - $totalKonsul }}x lagi</small>
                            @else
                                <br><small class="text-success">✓ Target tercapai!</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form & History --}}
            <div class="col-lg-8">
                {{-- Form Input Konsultasi --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <h5 class="mb-0">
                            <i class="bi bi-journal-plus me-2"></i>Input Hasil Konsultasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('konsultasi.store') }}" method="POST" id="formKonsultasi">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Konsultasi</label>
                                <input type="date" name="tanggal_konsul" class="form-control @error('tanggal_konsul') is-invalid @enderror" value="{{ old('tanggal_konsul', date('Y-m-d')) }}" required>
                                @error('tanggal_konsul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Hasil Konsultasi</label>
                                <textarea name="hasil_konsul" id="summernote" class="form-control @error('hasil_konsul') is-invalid @enderror">{{ old('hasil_konsul') }}</textarea>
                                @error('hasil_konsul')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Gunakan toolbar untuk format teks (bold, italic, list, dll)</small>
                            </div>

                            <button type="submit" class="btn btn-maroon">
                                <i class="bi bi-save me-1"></i> Simpan Hasil Konsultasi
                            </button>
                        </form>
                    </div>
                </div>

                {{-- History Konsultasi --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-3">
                        <h5 class="fw-bold mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Konsultasi</h5>
                    </div>
                    <div class="card-body">
                        @if ($konsultasi->count() > 0)
                            <div class="timeline">
                                @foreach ($konsultasi as $k)
                                    <div class="card mb-3 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="fw-bold mb-1">
                                                        <i class="bi bi-calendar-check text-primary me-1"></i>
                                                        {{ \Carbon\Carbon::parse($k->tanggal_konsul)->format('d F Y') }}
                                                    </h6>
                                                    <small class="text-muted">
                                                        Dibuat: {{ $k->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('konsultasi.edit', $k->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('konsultasi.destroy', $k->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus konsultasi ini?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="hasil-konsul">{!! $k->hasil_konsul !!}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
                                <p class="text-muted mt-3">Belum ada riwayat konsultasi</p>
                                <small class="text-muted">Mulai konsultasi dengan mengisi form di atas</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Tambahkan Scripts Summernote --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Tulis hasil diskusi, saran dari pembimbing, catatan penting, dll...',
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '36'],
            styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        });

        // Validasi form sebelum submit
        $('#formKonsultasi').on('submit', function(e) {
            var content = $('#summernote').summernote('code');
            var text = $('<div>').html(content).text().trim();
            
            if (text.length < 10) {
                e.preventDefault();
                alert('Hasil konsultasi harus minimal 10 karakter!');
                $('#summernote').summernote('focus');
                return false;
            }
        });
    });
</script>
@endpush