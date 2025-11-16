@extends('layouts.app')

@section('title', 'Edit Data MOU')
@section('page-title', 'Edit Data MOU') {{-- Tetap di sini jika layout Anda membutuhkannya --}}

@section('content')
    {{-- 
      =====================================================
      STYLE KUSTOM STANDAR (Maroon Header & Pill Button)
      =====================================================
    --}}
    <style>
        :root {
            --custom-maroon: #7c1316;
            --custom-maroon-light: #a3191d;
            --custom-maroon-subtle: #fcf0f1;
            --text-dark: #2c3e50;
            --text-muted: #95a5a6;
            --card-radius: 16px;
            --transition: 0.3s ease;
        }

        /* --- Card Styling --- */
        .form-card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: #fff;
            overflow: hidden;
        }

        .card-header-custom {
            background-color: var(--custom-maroon);
            padding: 1.5rem;
            color: white;
            border-bottom: 4px solid var(--custom-maroon-light);
        }

        /* --- Form Styling --- */
        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            color: var(--custom-maroon);
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .form-control,
        .form-select {
            border-left: none;
            border-radius: 0 10px 10px 0;
            padding: 0.7rem 1rem;
            border-color: #dee2e6;
            box-shadow: none !important;
            transition: border-color 0.2s;
        }

        /* Khusus untuk file input agar tidak aneh */
        .form-control[type="file"] {
            padding-top: 0.85rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--custom-maroon-light);
        }

        /* --- Buttons --- */
        .btn-maroon {
            background-color: var(--custom-maroon);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(124, 19, 22, 0.2);
        }

        .btn-maroon:hover {
            background-color: var(--custom-maroon-light);
            transform: translateY(-2px);
            color: white;
        }

        .btn-light-custom {
            background: #fff;
            border: 1px solid #dee2e6;
            color: var(--text-dark);
            border-radius: 50px;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
        }

        .btn-light-custom:hover {
            background: #f8f9fa;
            color: var(--custom-maroon);
        }

        /* Animation */
        .animate-up {
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    {{-- ================= END STYLE ================= --}}


    {{-- 
      =====================================================
      STRUKTUR HTML BARU MENGIKUTI STYLE STANDAR
      =====================================================
    --}}
    <div class="row justify-content-center animate-up">
        <div class="col-md-9 col-lg-8">
            <div class="form-card">

                {{-- CARD HEADER --}}
                <div class="card-header-custom">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-pencil-square me-2"></i> Form Edit MOU
                    </h4>
                    <p class="mb-0 small opacity-75">Perbarui detail Memorandum of Understanding.</p>
                </div>

                {{-- CARD BODY --}}
                <div class="card-body p-4 p-md-5">

                    {{-- ERROR VALIDASI --}}
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 shadow-sm mb-4">
                            <h6 class="alert-heading fw-bold">Whoops! Ada masalah.</h6>
                            <ul class="mb-0 small ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('mou.update', $mou->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- PENTING untuk method UPDATE --}}

                        {{-- SEKSI 1 --}}
                        <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                            Informasi MOU
                        </h6>

                        <div class="mb-3">
                            <label class="form-label">Nama Universitas <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                <input type="text" class="form-control @error('nama_universitas') is-invalid @enderror"
                                    name="nama_universitas" value="{{ old('nama_universitas', $mou->nama_universitas) }}"
                                    required>
                            </div>
                            @error('nama_universitas')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-plus"></i></span>
                                    <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                        name="tanggal_masuk"
                                        value="{{ old('tanggal_masuk', $mou->tanggal_masuk->format('Y-m-d')) }}" required>
                                </div>
                                @error('tanggal_masuk')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Keluar <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" class="form-control @error('tanggal_keluar') is-invalid @enderror"
                                        name="tanggal_keluar"
                                        value="{{ old('tanggal_keluar', $mou->tanggal_keluar->format('Y-m-d')) }}" required>
                                </div>
                                @error('tanggal_keluar')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4 border-light">

                        {{-- SEKSI 2 --}}
                        <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                            Upload Dokumen (Opsional)
                        </h6>

                        <div class="mb-3">
                            <label class="form-label">Upload File MOU <span class="text-info">(Opsional)</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-file-earmark-pdf-fill"></i></span>
                                <input type="file" class="form-control @error('file_mou') is-invalid @enderror"
                                    name="file_mou">
                            </div>
                            <small class="form-text text-muted ms-1">
                                File saat ini: <a href="{{ Storage::url($mou->file_mou) }}" target="_blank">Lihat File</a>
                                <br>
                                Kosongkan jika tidak ingin mengubah file. (PDF/DOCX, Maks 5MB)
                            </small>
                            @error('file_mou')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Surat Keterangan <span
                                    class="text-info">(Opsional)</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-file-earmark-image-fill"></i></span>
                                <input type="file" class="form-control @error('surat_keterangan') is-invalid @enderror"
                                    name="surat_keterangan">
                            </div>
                            <small class="form-text text-muted ms-1">
                                File saat ini: <a href="{{ Storage::url($mou->surat_keterangan) }}" target="_blank">Lihat
                                    Surat</a>
                                <br>
                                Kosongkan jika tidak ingin mengubah file. (PDF/JPG/PNG, Maks 5MB)
                            </small>
                            @error('surat_keterangan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4 border-light">

                        {{-- SEKSI 3 --}}
                        <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                            Catatan (Opsional)
                        </h6>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <div class="input-group">
                                <span class="input-group-text align-items-start pt-3"><i
                                        class="bi bi-pencil-square"></i></span>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="4"
                                    placeholder="Tambahkan catatan jika perlu...">{{ old('keterangan', $mou->keterangan) }}</textarea>
                            </div>
                            @error('keterangan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="d-flex justify-content-between align-items-center pt-4">
                            <a href="{{ route('mou.index') }}" class="btn btn-light-custom shadow-sm">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-maroon">
                                Simpan Perubahan <i class="bi bi-check-lg ms-2"></i>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk SweetAlert (dari kode Anda) --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 1800,
                    toast: true,
                    position: 'top-end'
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: '{{ session('error') }}',
                    showConfirmButton: true
                });
            });
        </script>
    @endif
@endsection

@section('scripts')
    {{-- Pastikan SweetAlert di-load, jika belum ada di layout utama --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
