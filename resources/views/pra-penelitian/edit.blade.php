@extends('layouts.app')

@section('title', 'Edit Pengajuan Pra Penelitian')
@section('page-title', 'Edit Pengajuan Pra Penelitian')

@section('content')
    <style>
        /* Style tetap sama seperti form create Anda */
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

        .card-header-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
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
        }

        .form-control,
        .form-select,
        textarea.form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
            padding: 0.7rem 1rem;
            border-color: #dee2e6;
            box-shadow: none !important;
            transition: border-color 0.2s;
            font-family: inherit;
        }

        .form-control[type="date"] {
            border-left: 1px solid #dee2e6;
            border-radius: 10px;
        }

        .input-group .form-control[type="date"] {
             border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .form-control:focus,
        .form-select:focus,
        textarea.form-control:focus {
            border-color: var(--custom-maroon-light);
            box-shadow: 0 0 0 0.2rem rgba(124, 19, 22, 0.1) !important;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.3rem;
        }

        .form-row-custom {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .form-row-custom {
                grid-template-columns: 1fr;
            }
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

        .btn-secondary-custom {
            background: #e9ecef;
            color: var(--text-dark);
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
            display: inline-block;
            text-decoration: none;
        }

        .btn-secondary-custom:hover {
            background: #dee2e6;
            color: var(--text-dark);
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: flex-start;
            margin-top: 2rem;
        }

        .card-body-custom {
            padding: 2rem;
        }

        .info-box {
            background: var(--custom-maroon-subtle);
            border: 1px dashed var(--custom-maroon-light);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .info-box i {
            margin-right: 0.5rem;
            color: var(--custom-maroon);
        }

        .dynamic-section {
            background: #f8f9fa;
            border: 2px dashed var(--custom-maroon);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .dynamic-section-title {
            font-weight: 700;
            color: var(--custom-maroon);
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        #tambah-mahasiswa {
            background: var(--custom-maroon);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            transition: var(--transition);
        }
        #tambah-mahasiswa:hover {
            background: var(--custom-maroon-light);
        }

        .hapus-mahasiswa {
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            width: 38px;
            height: 38px;
            line-height: 38px;
            text-align: center;
            padding: 0;
            transition: var(--transition);
        }
        .hapus-mahasiswa:hover {
            background: #c0392b;
        }

        #mahasiswa-list .form-control {
            border-left: 1px solid #dee2e6;
            border-radius: 10px;
        }

        #mahasiswa-list .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        #mahasiswa-list .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            color: var(--custom-maroon);
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

    </style>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-card">
                <div class="card-header-custom">
                    <h2 class="card-header-title">
                        <i class="fas fa-edit"></i> {{-- Icon diganti edit --}}
                        Edit Pengajuan Pra Penelitian
                    </h2>
                </div>

                <div class="card-body-custom">

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <strong>Terjadi kesalahan!</strong>
                            <ul style="margin: 0.5rem 0 0 0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        Silakan ubah data yang diperlukan. Pastikan data mahasiswa tetap terisi minimal 1 orang.
                    </div>

                    {{-- Form diarahkan ke route UPDATE --}}
                    <form action="{{ route('pra-penelitian.update', $praPenelitian->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Wajib ada untuk proses Edit --}}

                        {{-- Data Penelitian Utama --}}
                        <div class="form-row-custom">
                            <div class="form-group">
                                <label for="judul" class="form-label">
                                    <i class="fas fa-file-alt"></i> Judul Pra Penelitian
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                    {{-- VALUE: Menggunakan old atau data dari database --}}
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                           id="judul" name="judul" value="{{ old('judul', $praPenelitian->judul) }}" placeholder="Masukkan judul" required>
                                </div>
                                @error('judul') <div class="error-message">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="mou_id" class="form-label">
                                    <i class="fas fa-university"></i> Universitas (MOU)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-university"></i></span>
                                    <select name="mou_id" id="mou_id" class="form-select @error('mou_id') is-invalid @enderror" required>
                                        <option value="">Pilih Universitas</option>
                                        @foreach ($mous as $mou)
                                            {{-- SELECTED LOGIC: Cek old atau data DB --}}
                                            <option value="{{ $mou->id }}" {{ old('mou_id', $praPenelitian->mou_id) == $mou->id ? 'selected' : '' }}>
                                                {{ $mou->nama_universitas }} (Exp: {{ $mou->tanggal_keluar->format('d M Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('mou_id') <div class="error-message">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-row-custom">
                            <div class="form-group">
                                <label for="jenis_penelitian" class="form-label">
                                    <i class="fas fa-tasks"></i> Jenis Penelitian
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tasks"></i></span>
                                    <select name="jenis_penelitian" id="jenis_penelitian" class="form-select @error('jenis_penelitian') is-invalid @enderror" required>
                                        {{-- SELECTED LOGIC --}}
                                        <option value="Data Awal" {{ old('jenis_penelitian', $praPenelitian->jenis_penelitian) == 'Data Awal' ? 'selected' : '' }}>Data Awal</option>
                                        <option value="Uji Validitas" {{ old('jenis_penelitian', $praPenelitian->jenis_penelitian) == 'Uji Validitas' ? 'selected' : '' }}>Uji Validitas</option>
                                        <option value="Penelitian" {{ old('jenis_penelitian', $praPenelitian->jenis_penelitian) == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                                    </select>
                                </div>
                                @error('jenis_penelitian') <div class="error-message">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="tanggal_mulai" class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Tanggal Mulai Penelitian
                                </label>
                                {{-- VALUE: Menggunakan format Y-m-d untuk input date --}}
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                       id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $praPenelitian->tanggal_mulai->format('Y-m-d')) }}" required>
                                @error('tanggal_mulai') <div class="error-message">{{ $message }}</div> @enderror
                            </div>
                        </div>


                        {{-- Data Mahasiswa Dinamis --}}
                        <div class="dynamic-section">
                            <div class="dynamic-section-title d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-users"></i> Data Mahasiswa</span>
                                <button type="button" id="tambah-mahasiswa" class="btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Mahasiswa
                                </button>
                            </div>

                            <div id="mahasiswa-list">
                                <div class="row g-3 mb-2 d-none d-md-flex" style="font-weight: 600; font-size: 0.9rem; color: var(--text-dark);">
                                    <div class="col-md-3">Nama Mahasiswa</div>
                                    <div class="col-md-3">No. Telpon (+62)</div>
                                    <div class="col-md-3">Jenjang</div>
                                    <div class="col-md-3">Aksi</div>
                                </div>
                                <hr class="d-none d-md-block mt-0 mb-3">

                                {{-- LOGIKA PENTING UNTUK EDIT DATA DINAMIS --}}
                                @php
                                    // Jika ada error validasi, gunakan data old.
                                    // Jika tidak, gunakan data dari database ($praPenelitian->mahasiswas)
                                    $mahasiswas = old('mahasiswas') ?? $praPenelitian->mahasiswas;
                                @endphp

                                @foreach ($mahasiswas as $i => $mhs)
                                    {{-- Penanganan perbedaan struktur data antara Array (old) dan Object Collection (Database) --}}
                                    @php
                                        $nama = is_array($mhs) ? $mhs['nama'] : $mhs->nama;
                                        $no_telpon = is_array($mhs) ? $mhs['no_telpon'] : $mhs->no_telpon;
                                        $jenjang = is_array($mhs) ? $mhs['jenjang'] : $mhs->jenjang;
                                    @endphp

                                    <div class="row g-3 mb-2 align-items-center mahasiswa-row">
                                        <div class="col-md-3">
                                            <input type="text" name="mahasiswas[{{ $i }}][nama]" class="form-control"
                                                   placeholder="Nama Mahasiswa" value="{{ $nama }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <span class="input-group-text">+62</span>
                                                <input type="tel" name="mahasiswas[{{ $i }}][no_telpon]" class="form-control"
                                                       placeholder="812..." value="{{ $no_telpon }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="mahasiswas[{{ $i }}][jenjang]" class="form-control"
                                                   placeholder="Jenjang (S1/D3/S2)" value="{{ $jenjang }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            {{-- Tombol hapus hanya muncul jika bukan baris pertama saat edit? Terserah aturan bisnis Anda.
                                                 Tapi di sini kita izinkan hapus, nanti JS menjaga minimal 1. --}}
                                            <button type="button" class="hapus-mahasiswa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="button-group">
                            <button type="submit" class="btn-maroon">
                                <i class="fas fa-save"></i>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('pra-penelitian.index') }}" class="btn-secondary-custom">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <template id="mahasiswa-template">
        <div class="row g-3 mb-2 align-items-center mahasiswa-row">
            <div class="col-md-3">
                <input type="text" name="mahasiswas[INDEX][nama]" class="form-control"
                       placeholder="Nama Mahasiswa" required>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text">+62</span>
                    <input type="tel" name="mahasiswas[INDEX][no_telpon]" class="form-control"
                           placeholder="812..." required>
                </div>
            </div>
            <div class="col-md-3">
                <input type="text" name="mahasiswas[INDEX][jenjang]" class="form-control"
                       placeholder="Jenjang (S1/D3/S2)" required>
            </div>
            <div class="col-md-3">
                <button type="button" class="hapus-mahasiswa">
                     <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </template>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const list = document.getElementById('mahasiswa-list');
            const addButton = document.getElementById('tambah-mahasiswa');
            const template = document.getElementById('mahasiswa-template');

            // --- PERUBAHAN PENTING UNTUK EDIT ---
            // Index dimulai dari jumlah mahasiswa yang sudah ada agar tidak menimpa name="" yang lama
            // Jika validasi gagal (old ada), pakai count old. Jika load awal, pakai count DB.
            let index = {{ old('mahasiswas') ? count(old('mahasiswas')) : $praPenelitian->mahasiswas->count() }};

            // --- FUNGSI FORMAT NO HP ---
            function formatPhoneNumber(input) {
                let value = input.value;
                if (value.startsWith('0')) value = value.substring(1);
                if (value.startsWith('+62')) value = value.substring(3);
                value = value.replace(/[^0-9]/g, '');
                input.value = value;
            }

            list.addEventListener('input', function(e) {
                if (e.target && e.target.name && e.target.name.includes('[no_telpon]')) {
                    formatPhoneNumber(e.target);
                }
            });

            // Format ulang data yang diambil dari DB saat halaman pertama kali dimuat
            document.querySelectorAll('input[name*="[no_telpon]"]').forEach(function(input) {
                formatPhoneNumber(input);
            });

            // --- TAMBAH BARIS ---
            addButton.addEventListener('click', function() {
                let newRowHtml = template.innerHTML.replace(/INDEX/g, index);
                let newRow = document.createElement('div');
                newRow.innerHTML = newRowHtml;
                list.appendChild(newRow.firstElementChild);
                index++;
            });

            // --- HAPUS BARIS ---
            list.addEventListener('click', function(e) {
                if (e.target && e.target.closest('.hapus-mahasiswa')) {
                    if (list.getElementsByClassName('mahasiswa-row').length <= 1) {
                         Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Minimal harus ada 1 mahasiswa.',
                            confirmButtonColor: '#7c1316'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Hapus baris ini?',
                        text: "Data yang diisi akan hilang.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#7c1316',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                             e.target.closest('.mahasiswa-row').remove();
                        }
                    });
                }
            });
        });
    </script>
@endsection