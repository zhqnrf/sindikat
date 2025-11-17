@extends('layouts.app')

@section('title', 'Tambah Pelatihan Dasar')
@section('page-title', 'Tambah Pelatihan Dasar')

@section('content')
    <style>
        /* ... (CSS Anda sudah benar) ... */
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

        /* Khusus untuk input file di section pelatihan */
        .pelatihan-item .form-control[type="file"] {
            border-left: 1px solid #dee2e6;
            border-radius: 6px;
        }

        /* Khusus untuk NIP/Gol/Pangkat */
        #pnsFields .form-control {
            border-left: 1px solid #dee2e6;
            border-radius: 6px;
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

        .pelatihan-dasar-section {
            background: #f8f9fa;
            border: 2px dashed var(--custom-maroon);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .pelatihan-dasar-title {
            font-weight: 700;
            color: var(--custom-maroon);
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        /* --- CSS DIPERBARUI DARI SOURCE --- */
        .pelatihan-item {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.8rem;
            align-items: flex-start; /* Diubah ke flex-start */
        }

        .pelatihan-item input[name*="pelatihan_dasar"] {
            flex: 2;
        }

        .pelatihan-item input[name*="tahun"] {
            flex: 0 0 120px;
        }

        /* TAMBAHAN: Style untuk input file */
        .pelatihan-item input[name*="pelatihan_file"] {
            flex: 1.5; /* Beri ruang lebih */
            font-size: 0.85rem;
            padding: 0.6rem; /* Sesuaikan padding */
            /* Menggunakan style form-control internal */
            border: 1px solid #dee2e6;
            border-radius: 6px;
        }

        .pelatihan-item input[name*="pelatihan_file"]:focus {
            border-color: var(--custom-maroon-light);
            box-shadow: 0 0 0 0.2rem rgba(124, 19, 22, 0.1);
        }

        .pelatihan-item .btn-remove {
             margin-top: 5px; /* Sedikit ke bawah agar sejajar */
             /* Pastikan btn-remove punya style */
             background: #e74c3c;
             color: white;
             border: none;
             border-radius: 5px;
             width: 38px;
             height: 38px;
             line-height: 38px;
             text-align: center;
             padding: 0;
        }
        .pelatihan-item .btn-remove:hover {
            background: #c0392b;
        }

        .btn-add-pelatihan {
            /* Style untuk tombol tambah */
            background: var(--custom-maroon);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            transition: var(--transition);
        }
        .btn-add-pelatihan:hover {
            background: var(--custom-maroon-light);
        }
        /* --- AKHIR CSS DIPERBARUI --- */

    </style>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="card-header-custom">
                    <h2 class="card-header-title">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Pelatihan Dasar
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
                        Isi data pelatihan dasar dengan lengkap. Anda bisa menambahkan multiple pelatihan, tahun, dan mengupload file PDF (Maks 2MB).
                    </div>

                    <form action="{{ route('pelatihan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row-custom">
                            <div class="form-group">
                                <label for="nama" class="form-label">
                                    <i class="fas fa-user"></i>
                                    Nama
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" placeholder="Masukkan nama" value="{{ old('nama') }}" required>
                                </div>
                                @error('nama')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jabatan" class="form-label">
                                    <i class="fas fa-briefcase"></i>
                                    Jabatan
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-briefcase"></i>
                                    </span>
                                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                        id="jabatan" name="jabatan" placeholder="Masukkan jabatan" value="{{ old('jabatan') }}">
                                </div>
                                @error('jabatan')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row-custom">
                            <div class="form-group">
                                <label for="is_pns" class="form-label">
                                    <i class="fas fa-id-card"></i>
                                    Status PNS
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-id-badge"></i>
                                    </span>
                                    <select id="is_pns" name="is_pns" class="form-select">
                                        <option value="0" {{ old('is_pns') == '1' ? '' : 'selected' }}>Non-PNS</option>
                                        <option value="1" {{ old('is_pns') == '1' ? 'selected' : '' }}>PNS</option>
                                    </select>
                                </div>
                                @error('is_pns')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group" id="pnsFields" style="display: none;">
                                <label class="form-label">
                                    <i class="fas fa-key"></i>
                                    NIP, Golongan & Pangkat
                                </label>
                                <div style="display: flex; gap: 0.5rem;">
                                    <input type="text" id="nip" name="nip" class="form-control @error('nip') is-invalid @enderror" placeholder="NIP" value="{{ old('nip') }}">
                                    <input type="text" id="golongan" name="golongan" class="form-control @error('golongan') is-invalid @enderror" placeholder="Golongan" value="{{ old('golongan') }}">
                                    <input type="text" id="pangkat" name="pangkat" class="form-control @error('pangkat') is-invalid @enderror" placeholder="Pangkat" value="{{ old('pangkat') }}">
                                </div>
                                @error('nip')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                                @error('golongan')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                                @error('pangkat')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>

                        <div class="form-group">
                            <label for="unit" class="form-label">
                                <i class="fas fa-building"></i>
                                Unit
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-building"></i>
                                </span>
                                <input type="text" class="form-control @error('unit') is-invalid @enderror"
                                    id="unit" name="unit" placeholder="Masukkan unit" value="{{ old('unit') }}">
                            </div>
                            @error('unit')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pelatihan-dasar-section">
                            <div class="pelatihan-dasar-title">
                                <i class="fas fa-graduation-cap"></i>
                                Pelatihan Dasar yang Dimiliki
                            </div>
                            <div style="display: grid; gap: 0.5rem; margin-bottom: 1rem;">
                                <div style="display: flex; gap: 1rem; font-weight: 600; font-size: 0.9rem; padding: 0.5rem; color: var(--text-dark);">
                                    <div style="flex: 2;">Nama Pelatihan</div>
                                    <div style="flex: 0 0 120px;">Tahun</div>
                                    <div style="flex: 1.5;">Upload PDF</div>
                                    <div style="flex: 0 0 50px;"></div>
                                </div>
                            </div>
                            <div id="pelatihanContainer">
                                @php
                                    $pelatihanArray = old('pelatihan_dasar', []);
                                    $tahunArray = old('pelatihan_tahun_simple', []);
                                    if (empty($pelatihanArray)) {
                                        $pelatihanArray = [''];
                                        $tahunArray = [''];
                                    }
                                @endphp
                                @foreach ($pelatihanArray as $index => $pelatihan)
                                    <div class="pelatihan-item">
                                        <input type="text" class="form-control" name="pelatihan_dasar[]"
                                            placeholder="Contoh: Workshop Excel, Pelatihan Leadership"
                                            value="{{ $pelatihan }}">
                                        <input type="number" class="form-control" name="pelatihan_tahun_simple[]"
                                            placeholder="Tahun" value="{{ $tahunArray[$index] ?? '' }}" min="1990" max="2099">

                                        <input type="file" class="form-control" name="pelatihan_file[]" accept=".pdf">

                                        @if ($index > 0)
                                            <button type="button" class="btn-remove" onclick="removePelatihan(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn-add-pelatihan mt-2" onclick="addPelatihan()">
                                <i class="fas fa-plus"></i> Tambah Pelatihan
                            </button>
                        </div>

                        <div class="button-group">
                            <button type="submit" class="btn-maroon">
                                <i class="fas fa-save"></i>
                                Simpan
                            </button>
                            <a href="{{ route('pelatihan.index') }}" class="btn-secondary-custom">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addPelatihan() {
            const container = document.getElementById('pelatihanContainer');
            const item = document.createElement('div');
            item.className = 'pelatihan-item';

            // Script addPelatihan tetap mempertahankan input file
            item.innerHTML = `
                <input type="text" class="form-control" name="pelatihan_dasar[]"
                    placeholder="Contoh: Workshop Excel, Pelatihan Leadership">
                <input type="number" class="form-control" name="pelatihan_tahun_simple[]"
                    placeholder="Tahun" min="1990" max="2099">

                <input type="file" class="form-control" name="pelatihan_file[]" accept=".pdf">

                <button type="button" class="btn-remove" onclick="removePelatihan(this)">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(item);
        }

        function removePelatihan(button) {
            const container = document.getElementById('pelatihanContainer');
            const pelatihans = container.querySelectorAll('.pelatihan-item');
            if (pelatihans.length > 1) {
                button.parentElement.remove();
            } else {
                // Ganti alert dengan membersihkan input jika hanya tersisa satu
                const firstItemInputs = pelatihans[0].querySelectorAll('input');
                firstItemInputs.forEach(input => input.value = '');
            }
        }

        // ===== SCRIPT INI DIPERBARUI DARI SOURCE =====
        function togglePnsFields() {
            const sel = document.getElementById('is_pns');
            const pnsContainer = document.getElementById('pnsFields');
            const nip = document.getElementById('nip');
            const golongan = document.getElementById('golongan');
            const pangkat = document.getElementById('pangkat'); // <-- TAMBAHAN

            if (!sel || !pnsContainer) return;

            if (sel.value === '1') {
                pnsContainer.style.display = 'block';
                if (nip) nip.setAttribute('required', 'required');
                if (golongan) golongan.setAttribute('required', 'required');
                if (pangkat) pangkat.setAttribute('required', 'required'); // <-- TAMBAHAN
            } else {
                pnsContainer.style.display = 'none';
                if (nip) nip.removeAttribute('required');
                if (golongan) golongan.removeAttribute('required');
                if (pangkat) pangkat.removeAttribute('required'); // <-- TAMBAHAN
            }
        }
        // ===== AKHIR SCRIPT DIPERBARUI =====

        document.addEventListener('DOMContentLoaded', function() {
            const sel = document.getElementById('is_pns');
            if (sel) {
                sel.addEventListener('change', togglePnsFields);
                togglePnsFields();
            }
        });
    </script>
    @endsection
