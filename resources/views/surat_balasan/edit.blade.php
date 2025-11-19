@extends('layouts.app')

@section('title', 'Edit Surat Balasan')
@section('page-title', 'Edit Surat Balasan')

@section('content')
    <style>
        /* --- Menggunakan Style Seragam --- */
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
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="row justify-content-center animate-up">
        <div class="col-md-10 col-lg-9">
            <div class="form-card">
                {{-- Header Card --}}
                <div class="card-header-custom">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-edit me-2"></i> Edit Surat Balasan
                    </h4>
                    <p class="mb-0 small opacity-75">Perbarui informasi surat balasan mahasiswa.</p>
                </div>

                {{-- Body Card --}}
                <div class="card-body p-4 p-md-5">

                    {{-- Tampilkan Error jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 shadow-sm mb-4">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('surat-balasan.update', $suratBalasan->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Include Form Partial --}}
                        {{-- Pastikan file partial 'surat_balasan.form' sudah menggunakan style input group baru --}}
                        @include('surat_balasan.form', ['edit' => true])

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top">
                            <a href="{{ route('surat-balasan.index') }}" class="btn btn-light-custom shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>

                            <button type="submit" class="btn btn-maroon">
                                Update Data <i class="fas fa-sync-alt ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
