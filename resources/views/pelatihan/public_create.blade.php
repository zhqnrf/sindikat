

@extends('layouts.public')

@section('title', 'Input Data Baru')

@section('content')
    {{-- Load Choices.js CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

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

        .form-card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: #fff;
            overflow: hidden;
            margin-bottom: 3rem;
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

        /* Khusus input file & conditional fields agar border rapi */
        .pelatihan-item .form-control[type="file"],
        .conditional-fields .form-control {
            border-left: 1px solid #dee2e6;
            border-radius: 6px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--custom-maroon-light);
            box-shadow: 0 0 0 0.2rem rgba(124, 19, 22, 0.1) !important;
        }

        .form-group { margin-bottom: 1.5rem; }

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
            .form-row-custom { grid-template-columns: 1fr; }
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

        .card-body-custom { padding: 2rem; }

        .info-box {
            background: var(--custom-maroon-subtle);
            border: 1px dashed var(--custom-maroon-light);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .info-box i { margin-right: 0.5rem; color: var(--custom-maroon); }

        .pelatihan-section {
            background: #f8f9fa;
            border: 2px dashed var(--custom-maroon);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .pelatihan-title {
            font-weight: 700;
            color: var(--custom-maroon);
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .pelatihan-item {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.8rem;
            align-items: flex-start;
        }

        .pelatihan-item input[type="text"] { flex: 2; }
        .pelatihan-item input[type="number"] { flex: 0 0 100px; }
        .pelatihan-item input[type="file"] {
            flex: 1.5;
            font-size: 0.85rem;
            padding: 0.6rem;
            border: 1px solid #dee2e6;
            border-radius: 6px;
        }

        .pelatihan-item .btn-remove {
             margin-top: 5px;
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
        .pelatihan-item .btn-remove:hover { background: #c0392b; }

        .btn-add-pelatihan {
            background: var(--custom-maroon);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            transition: var(--transition);
        }
        .btn-add-pelatihan:hover { background: var(--custom-maroon-light); }

        /* Choices JS Override */
        .choices__inner {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0 10px 10px 0;
            min-height: 45px;
            padding: 5px 10px;
            font-size: 1rem;
        }
        .choices:focus-within .choices__inner {
            border-color: var(--custom-maroon-light);
            box-shadow: 0 0 0 0.2rem rgba(124, 19, 22, 0.1);
        }
        .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background-color: var(--custom-maroon);
            color: #fff;
        }
        .input-group > .choices { flex: 1 1 auto; width: 1%; min-width: 0; }

        .animate-up { animation: fadeInUp 0.6s forwards; opacity: 0; transform: translateY(20px); }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Tombol Kembali --}}
                <a href="{{ route('public.pelatihan.index') }}" class="btn btn-link text-secondary mb-3" style="text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Pencarian
                </a>

                <div class="form-card animate-up">
                    <div class="card-header-custom">
                        <h2 class="card-header-title">
                            <i class="fas fa-user-plus me-2"></i> Tambah Data Pegawai & Pelatihan
                        </h2>
                    </div>

                    <div class="card-body-custom">
                        {{-- Error Display --}}
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
                            Isi data pegawai dan pelatihan dengan lengkap. Anda bisa mengupload file PDF (Maks 2MB) untuk setiap pelatihan.
                        </div>

                        {{-- FORM START --}}
                        <form action="{{ route('public.pelatihan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- ROW 1: Nama & Jabatan --}}
                            <div class="form-row-custom">
                                <div class="form-group">
                                    <label for="nama" class="form-label">
                                        <i class="fas fa-user"></i> Nama
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" placeholder="Masukkan nama" value="{{ old('nama') }}" required>
                                    </div>
                                    @error('nama') <div class="error-message">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="jabatan" class="form-label">
                                        <i class="fas fa-briefcase"></i> Jabatan
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                            id="jabatan" name="jabatan" placeholder="Masukkan jabatan" value="{{ old('jabatan') }}">
                                    </div>
                                    @error('jabatan') <div class="error-message">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- ROW 2: Unit & Bidang --}}
                            <div class="form-row-custom">
                                <div class="form-group">
                                    <label for="unit" class="form-label">
                                        <i class="fas fa-building"></i> Unit/Ruang
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        <input type="text" class="form-control @error('unit') is-invalid @enderror"
                                            id="unit" name="unit" placeholder="Masukkan unit" value="{{ old('unit') }}">
                                    </div>
                                    @error('unit') <div class="error-message">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="bidang" class="form-label">
                                        <i class="fas fa-layer-group"></i> Bidang
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                        <select id="bidang" name="bidang" class="form-control @error('bidang') is-invalid @enderror" required>
                                            <option value="" placeholder>-- Pilih Bidang --</option>
                                            <option value="Keperawatan" {{ old('bidang') == 'Keperawatan' ? 'selected' : '' }}>Keperawatan</option>
                                            <option value="Pelayanan Medik" {{ old('bidang') == 'Pelayanan Medik' ? 'selected' : '' }}>Pelayanan Medik</option>
                                            <option value="Penunjang Klinik" {{ old('bidang') == 'Penunjang Klinik' ? 'selected' : '' }}>Penunjang Klinik</option>
                                            <option value="Penunjang Non Klinik" {{ old('bidang') == 'Penunjang Non Klinik' ? 'selected' : '' }}>Penunjang Non Klinik</option>
                                            <option value="Kepegawaian" {{ old('bidang') == 'Kepegawaian' ? 'selected' : '' }}>Kepegawaian</option>
                                            <option value="Perencanaan" {{ old('bidang') == 'Perencanaan' ? 'selected' : '' }}>Perencanaan</option>
                                            <option value="Keuangan" {{ old('bidang') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                                        </select>
                                    </div>
                                    @error('bidang') <div class="error-message">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- ROW 3: Status Pegawai --}}
                            <div class="form-row-custom">
                                <div class="form-group">
                                    <label for="status_pegawai" class="form-label">
                                        <i class="fas fa-id-card"></i> Status Pegawai
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                        <select id="status_pegawai" name="status_pegawai" class="form-select @error('status_pegawai') is-invalid @enderror" required>
                                            <option value="">-- Pilih Status --</option>
                                            <option value="PNS" {{ old('status_pegawai') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                            <option value="P3K" {{ old('status_pegawai') == 'P3K' ? 'selected' : '' }}>P3K</option>
                                            <option value="Non-PNS" {{ old('status_pegawai') == 'Non-PNS' ? 'selected' : '' }}>Non-PNS</option>
                                        </select>
                                    </div>
                                    @error('status_pegawai') <div class="error-message">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group conditional-fields">
                                    {{-- PNS FIELDS --}}
                                    <div id="pnsFields" style="display: none;">
                                        <label class="form-label">
                                            <i class="fas fa-key"></i> Detail Kepegawaian
                                        </label>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <input type="text" id="nip" name="nip" class="form-control" placeholder="NIP" value="{{ old('nip') }}">
                                            <input type="text" id="golongan" name="golongan" class="form-control" placeholder="Golongan" value="{{ old('golongan') }}">
                                            <div id="wrapper_pangkat" style="width: 100%;">
                                                <input type="text" id="pangkat" name="pangkat" class="form-control" placeholder="Pangkat" value="{{ old('pangkat') }}">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- NON PNS FIELDS --}}
                                    <div id="nonPnsFields" style="display: none;">
                                        <label class="form-label">
                                            <i class="fas fa-key"></i> NIRP
                                        </label>
                                        <div class="input-group">
                                            <input type="text" id="nirp" name="nirp" class="form-control" placeholder="Masukkan NIRP" value="{{ old('nirp') }}">
                                        </div>
                                    </div>

                                    @error('nip') <div class="error-message">NIP: {{ $message }}</div> @enderror
                                    @error('golongan') <div class="error-message">Golongan: {{ $message }}</div> @enderror
                                    @error('pangkat') <div class="error-message">Pangkat: {{ $message }}</div> @enderror
                                    @error('nirp') <div class="error-message">NIRP: {{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- SECTION: PELATIHAN DASAR --}}
                            <div class="pelatihan-section">
                                <div class="pelatihan-title">
                                    <i class="fas fa-graduation-cap"></i> Pelatihan Dasar
                                </div>
                                <div id="pelatihanDasarContainer">
                                    <div class="pelatihan-item">
                                        <input type="text" class="form-control" name="pelatihan_dasar[]" placeholder="Contoh: Pelatihan Prajabatan">
                                        <input type="number" class="form-control" name="pelatihan_tahun_dasar[]" placeholder="Tahun" min="1990" max="2099">
                                        <input type="file" class="form-control" name="pelatihan_file_dasar[]" accept=".pdf">
                                    </div>
                                </div>
                                <button type="button" class="btn-add-pelatihan mt-2" onclick="addPelatihanDasar()">
                                    <i class="fas fa-plus"></i> Tambah Pelatihan Dasar
                                </button>
                            </div>

                            {{-- SECTION: PELATIHAN KOMPETENSI --}}
                            <div class="pelatihan-section">
                                <div class="pelatihan-title">
                                    <i class="fas fa-chart-line"></i> Pelatihan Peningkatan Kompetensi
                                </div>
                                <div id="pelatihanKompetensiContainer">
                                    <div class="pelatihan-item">
                                        <input type="text" class="form-control" name="pelatihan_kompetensi[]" placeholder="Contoh: Workshop Teknis">
                                        <input type="number" class="form-control" name="pelatihan_tahun_kompetensi[]" placeholder="Tahun" min="1990" max="2099">
                                        <input type="file" class="form-control" name="pelatihan_file_kompetensi[]" accept=".pdf">
                                    </div>
                                </div>
                                <button type="button" class="btn-add-pelatihan mt-2" onclick="addPelatihanKompetensi()">
                                    <i class="fas fa-plus"></i> Tambah Pelatihan Kompetensi
                                </button>
                            </div>

                            <div class="button-group">
                                <button type="submit" class="btn-maroon">
                                    <i class="fas fa-save"></i> Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Load Choices.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
        // --- INIT CHOICES.JS ---
        document.addEventListener('DOMContentLoaded', function() {
            const element = document.getElementById('bidang');
            if(element) {
                const choices = new Choices(element, {
                    searchEnabled: true,
                    itemSelectText: '',
                    placeholder: true,
                    placeholderValue: '-- Pilih Bidang --',
                    shouldSort: false,
                });
            }
            // Trigger status check on load
            toggleStatusFields();
        });

        // --- FUNGSI TAMBAH BARIS PELATIHAN DASAR ---
        function addPelatihanDasar() {
            const container = document.getElementById('pelatihanDasarContainer');
            const item = document.createElement('div');
            item.className = 'pelatihan-item';
            item.innerHTML = `
                <input type="text" class="form-control" name="pelatihan_dasar[]" placeholder="Contoh: Pelatihan Prajabatan">
                <input type="number" class="form-control" name="pelatihan_tahun_dasar[]" placeholder="Tahun" min="1990" max="2099">
                <input type="file" class="form-control" name="pelatihan_file_dasar[]" accept=".pdf">
                <button type="button" class="btn-remove" onclick="removeRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(item);
        }

        // --- FUNGSI TAMBAH BARIS PELATIHAN KOMPETENSI ---
        function addPelatihanKompetensi() {
            const container = document.getElementById('pelatihanKompetensiContainer');
            const item = document.createElement('div');
            item.className = 'pelatihan-item';
            item.innerHTML = `
                <input type="text" class="form-control" name="pelatihan_kompetensi[]" placeholder="Contoh: Workshop Teknis">
                <input type="number" class="form-control" name="pelatihan_tahun_kompetensi[]" placeholder="Tahun" min="1990" max="2099">
                <input type="file" class="form-control" name="pelatihan_file_kompetensi[]" accept=".pdf">
                <button type="button" class="btn-remove" onclick="removeRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(item);
        }

        // --- FUNGSI HAPUS BARIS ---
        function removeRow(button) {
            button.parentElement.remove();
        }

        // --- LOGIKA STATUS PEGAWAI ---
        function toggleStatusFields() {
            const sel = document.getElementById('status_pegawai');
            const pnsContainer = document.getElementById('pnsFields');
            const nonPnsContainer = document.getElementById('nonPnsFields');
            const wrapperPangkat = document.getElementById('wrapper_pangkat');

            const nip = document.getElementById('nip');
            const golongan = document.getElementById('golongan');
            const pangkat = document.getElementById('pangkat');
            const nirp = document.getElementById('nirp');

            if (!sel) return;
            const val = sel.value;

            // Reset display
            pnsContainer.style.display = 'none';
            nonPnsContainer.style.display = 'none';
            wrapperPangkat.style.display = 'none';

            // Reset required
            if(nip) nip.removeAttribute('required');
            if(golongan) golongan.removeAttribute('required');
            if(pangkat) pangkat.removeAttribute('required');
            if(nirp) nirp.removeAttribute('required');

            if (val === 'PNS') {
                pnsContainer.style.display = 'block';
                wrapperPangkat.style.display = 'block';
                if(nip) nip.setAttribute('required', 'required');
                if(golongan) golongan.setAttribute('required', 'required');
                if(pangkat) pangkat.setAttribute('required', 'required');

            } else if (val === 'P3K') {
                pnsContainer.style.display = 'block';
                wrapperPangkat.style.display = 'none';
                if(nip) nip.setAttribute('required', 'required');
                if(golongan) golongan.setAttribute('required', 'required');


            } else if (val === 'Non-PNS') {
                nonPnsContainer.style.display = 'block';
                if(nirp) nirp.setAttribute('required', 'required');
            }
        }

        // Event Listener untuk Select Status
        const selStatus = document.getElementById('status_pegawai');
        if (selStatus) {
            selStatus.addEventListener('change', toggleStatusFields);
        }
    </script>
@endsection


