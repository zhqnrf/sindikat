@extends('layouts.app')

@section('title', 'Form Surat Balasan')
@section('page-title', 'Form Surat Balasan')

@section('content')
    <style>
        /* --- Menggunakan Style dari Referensi --- */
        :root {
            --custom-maroon: #7c1316;
            --custom-maroon-light: #a3191d;
            --custom-maroon-subtle: #fcf0f1;
            --text-dark: #2c3e50;
            --text-muted: #95a5a6;
            --card-radius: 16px;
            --transition: 0.3s ease;
        }

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
            min-width: 45px; /* Agar lebar icon seragam */
            justify-content: center;
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

        .form-control:focus,
        .form-select:focus {
            border-color: var(--custom-maroon-light);
        }

        /* Khusus Textarea agar icon tetap di atas */
        .input-group.align-items-start .input-group-text {
            padding-top: 0.8rem;
            height: auto;
            border-bottom-left-radius: 0; /* Sesuaikan jika perlu */
        }

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
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
        }

        .btn-light-custom:hover {
            background: #f8f9fa;
            color: var(--custom-maroon);
        }

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

    <div class="row justify-content-center animate-up">
        <div class="col-md-10 col-lg-9"> {{-- Lebar disesuaikan karena banyak kolom --}}
            <div class="form-card">
                <div class="card-header-custom">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-envelope-open-text me-2"></i> Form Surat Balasan</h4>
                    <p class="mb-0 small opacity-75">Lengkapi data mahasiswa dan detail keperluan surat.</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    {{-- Error Handling --}}
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 shadow-sm mb-4">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Mulai Form (Sesuaikan action route Anda) --}}
                    <form action="{{ route('surat-balasan.store') }}" method="POST">
                        @csrf

                        {{-- BAGIAN 1: IDENTITAS --}}
                        <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                            Identitas Mahasiswa
                        </h6>

                        <div class="row">
                            {{-- Baris 1: Nama & NIM --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Mahasiswa</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                                    <input type="text" name="nama_mahasiswa" class="form-control"
                                        placeholder="Masukkan nama mahasiswa"
                                        value="{{ old('nama_mahasiswa', $suratBalasan->nama_mahasiswa ?? '') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIM</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="nim" class="form-control"
                                        placeholder="Masukkan NIM"
                                        value="{{ old('nim', $suratBalasan->nim ?? '') }}" required>
                                </div>
                            </div>

                            {{-- Baris 2: WA & Prodi --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No WA Mahasiswa</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                    <input type="text" name="wa_mahasiswa" class="form-control"
                                        placeholder="Contoh: 0812..."
                                        value="{{ old('wa_mahasiswa', $suratBalasan->wa_mahasiswa ?? '') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Program Studi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-university"></i></span>
                                    <input type="text" name="prodi" class="form-control"
                                        placeholder="Masukkan Program Studi"
                                        value="{{ old('prodi', $suratBalasan->prodi ?? '') }}" required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 border-light">

                        {{-- BAGIAN 2: DETAIL SURAT --}}
                        <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                            Detail Keperluan
                        </h6>

                        <div class="mb-3">
                            <label class="form-label">Keperluan </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                <input type="text" name="keperluan" class="form-control"
                                    placeholder="Contoh: Kepentingan Penelitian atau Magang"
                                    value="{{ old('keperluan', $suratBalasan->keperluan ?? '') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Baris 4: Universitas & Mahasiswa Penelitian --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Universitas MOU</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                                    <select name="mou_id" class="form-select" required>
                                        <option value="">-- Pilih Universitas --</option>
                                        @foreach($mous as $mou)
                                            <option value="{{ $mou->id }}"
                                                {{ old('mou_id', $suratBalasan->mou_id ?? '') == $mou->id ? 'selected' : '' }}>
                                                {{ $mou->nama_universitas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Baris 5: Lama Berlaku --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Lama Berlaku Surat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    <input type="text" name="lama_berlaku" class="form-control"
                                        placeholder="Contoh: 3 Bulan, 1 Semester"
                                        value="{{ old('lama_berlaku', $suratBalasan->lama_berlaku ?? '') }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- Baris 6: Data (Textarea) --}}
                        <div class="mb-4">
                            <label class="form-label">Data Yang Dibutuhkan</label>
                            <div class="input-group align-items-start">
                                <span class="input-group-text"><i class="fas fa-database"></i></span>
                                <textarea name="data_dibutuhkan" class="form-control" rows="4"
                                    placeholder="Sebutkan data yang dibutuhkan secara spesifik..." required>{{ old('data_dibutuhkan', $suratBalasan->data_dibutuhkan ?? '') }}</textarea>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-between align-items-center pt-3">
                            <a href="{{ route('surat-balasan.index') }}" class="btn btn-light-custom shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-maroon">
                                Simpan Data <i class="fas fa-check-circle ms-2"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
