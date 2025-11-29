@extends('layouts.app')

@section('title', 'Edit Konsultasi')
@section('page-title', 'Edit Hasil Konsultasi')

{{-- CSS Summernote --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
</style>
@endpush

@section('content')
    <div class="container py-4">
        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('konsultasi.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-maroon text-white">
                        <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Hasil Konsultasi</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('konsultasi.update', $konsultasi->id) }}" method="POST" id="formEditKonsultasi">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Konsultasi</label>
                                <input type="date" name="tanggal_konsul" class="form-control @error('tanggal_konsul') is-invalid @enderror" value="{{ old('tanggal_konsul', $konsultasi->tanggal_konsul->format('Y-m-d')) }}" required>
                                @error('tanggal_konsul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Hasil Konsultasi</label>
                                <textarea name="hasil_konsul" id="summernoteEdit" class="form-control @error('hasil_konsul') is-invalid @enderror">{{ old('hasil_konsul', $konsultasi->hasil_konsul) }}</textarea>
                                @error('hasil_konsul')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-maroon">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('konsultasi.index') }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Scripts Summernote --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernoteEdit').summernote({
            height: 400,
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

        // Validasi form
        $('#formEditKonsultasi').on('submit', function(e) {
            var content = $('#summernoteEdit').summernote('code');
            var text = $('<div>').html(content).text().trim();
            
            if (text.length < 10) {
                e.preventDefault();
                alert('Hasil konsultasi harus minimal 10 karakter!');
                $('#summernoteEdit').summernote('focus');
                return false;
            }
        });
    });
</script>
@endpush