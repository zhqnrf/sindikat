@extends('layouts.public')

@section('title', 'Perbarui Pelatihan')

@section('content')
    <style>
        :root {
            --custom-maroon: #7c1316;
            --custom-maroon-light: #a3191d;
            --custom-maroon-subtle: #fcf0f1;
            --text-dark: #2c3e50;
            --card-radius: 16px;
            --transition: 0.3s ease;
        }

        /* Card & Layout */
        .form-card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: #fff;
            overflow: hidden;
            margin-top: 2rem;
            margin-bottom: 2rem;
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
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body-custom {
            padding: 2rem;
        }

        /* Info Box */
        .info-box {
            background: var(--custom-maroon-subtle);
            border: 1px dashed var(--custom-maroon-light);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 1rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-box strong {
            color: var(--custom-maroon);
        }

        /* Form Controls */
        .form-control {
            border-radius: 8px;
            padding: 0.7rem 1rem;
            border: 1px solid #dee2e6;
        }

        .form-control:focus {
            border-color: var(--custom-maroon-light);
            box-shadow: 0 0 0 0.2rem rgba(124, 19, 22, 0.1) !important;
        }

        /* Pelatihan Section (Dashed Box) */
        .pelatihan-section {
            background: #f8f9fa;
            border: 2px dashed #d1d1d1;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: var(--transition);
        }

        .pelatihan-section:hover {
            border-color: var(--custom-maroon-light);
        }

        .pelatihan-title {
            font-weight: 700;
            color: var(--custom-maroon);
            margin-bottom: 1rem;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Pelatihan Item Rows */
        .pelatihan-item {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            align-items: flex-start;
            background: white;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .pelatihan-item input[type="text"] { flex: 2; }
        .pelatihan-item input[type="number"] { width: 100px; }
        .pelatihan-item .file-wrapper { flex: 1.5; display: flex; flex-direction: column; gap: 4px; }
        .pelatihan-item input[type="file"] { font-size: 0.85rem; }

        /* Existing File Badge */
        .current-file {
            font-size: 0.75rem;
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
            color: #555;
        }
        .current-file a { color: var(--custom-maroon); text-decoration: none; font-weight: bold; }

        /* Buttons */
        .btn-remove {
            background: #fee2e2;
            color: #dc2626;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        .btn-remove:hover { background: #dc2626; color: white; }

        .btn-add-pelatihan {
            background: var(--custom-maroon);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
            font-weight: 600;
            transition: var(--transition);
        }
        .btn-add-pelatihan:hover { background: var(--custom-maroon-light); transform: translateY(-1px); }

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
        .btn-maroon:hover { background-color: var(--custom-maroon-light); transform: translateY(-2px); color: white; }

        .btn-secondary-custom {
            background: #e9ecef;
            color: var(--text-dark);
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }
        .btn-secondary-custom:hover { background: #dee2e6; color: var(--text-dark); }

        .button-group { display: flex; gap: 1rem; margin-top: 2rem; }

        /* Responsive */
        @media (max-width: 768px) {
            .pelatihan-item { flex-direction: column; }
            .pelatihan-item input, .pelatihan-item .file-wrapper, .pelatihan-item button { width: 100%; }
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <div class="form-card">
                    <div class="card-header-custom">
                        <h2 class="card-header-title">
                            <i class="fas fa-edit"></i> Perbarui Data Pelatihan
                        </h2>
                    </div>

                    <div class="card-body-custom">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="info-box">
                            <i class="fas fa-user-circle fa-lg"></i>
                            <div>
                                Anda sedang memperbarui data pelatihan untuk: <strong>{{ $pelatihan->nama }}</strong>
                            </div>
                        </div>

                        <form action="{{ route('public.pelatihan.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="pelatihan-section">
                                <div class="pelatihan-title">
                                    <i class="fas fa-graduation-cap"></i> Pelatihan Dasar
                                </div>
                                <div id="pelatihanDasarContainer">
                                    @php $dasar = $pelatihan->pelatihan_dasar ?? []; @endphp
                                    @if(is_array($dasar) && count($dasar) > 0)
                                        @foreach($dasar as $i => $item)
                                            <div class="pelatihan-item">
                                                <input type="text" name="pelatihan_dasar[]" class="form-control" value="{{ $item['nama'] ?? '' }}" placeholder="Nama Pelatihan">
                                                <input type="number" name="pelatihan_tahun_dasar[]" class="form-control" value="{{ $item['tahun'] ?? '' }}" placeholder="Thn">

                                                <div class="file-wrapper">
                                                    <input type="file" name="pelatihan_file_dasar[]" class="form-control">
                                                    <input type="hidden" name="pelatihan_existing_file_dasar[]" value="{{ $item['file'] ?? '' }}">

                                                    @if(!empty($item['file']))
                                                        <div class="current-file">
                                                            <i class="fas fa-file-pdf"></i> File ada.
                                                            <a href="{{ Storage::url($item['file']) }}" target="_blank">Lihat</a>
                                                        </div>
                                                    @endif
                                                </div>

                                                <button type="button" class="btn-remove" onclick="removeRow(this)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-muted small fst-italic mb-2" id="emptyDasarMsg">Belum ada data pelatihan dasar.</div>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <button type="button" class="btn-add-pelatihan" onclick="addPelatihanDasar()">
                                        <i class="fas fa-plus"></i> Tambah Dasar
                                    </button>
                                </div>
                            </div>

                            <div class="pelatihan-section">
                                <div class="pelatihan-title">
                                    <i class="fas fa-chart-line"></i> Peningkatan Kompetensi
                                </div>
                                <div id="pelatihanKompetensiContainer">
                                    @php $komp = $pelatihan->pelatihan_peningkatan_kompetensi ?? []; @endphp
                                    @if(is_array($komp) && count($komp) > 0)
                                        @foreach($komp as $i => $item)
                                            <div class="pelatihan-item">
                                                <input type="text" name="pelatihan_kompetensi[]" class="form-control" value="{{ $item['nama'] ?? '' }}" placeholder="Nama Pelatihan">
                                                <input type="number" name="pelatihan_tahun_kompetensi[]" class="form-control" value="{{ $item['tahun'] ?? '' }}" placeholder="Thn">

                                                <div class="file-wrapper">
                                                    <input type="file" name="pelatihan_file_kompetensi[]" class="form-control">
                                                    <input type="hidden" name="pelatihan_existing_file_kompetensi[]" value="{{ $item['file'] ?? '' }}">

                                                    @if(!empty($item['file']))
                                                        <div class="current-file">
                                                            <i class="fas fa-file-pdf"></i> File ada.
                                                            <a href="{{ Storage::url($item['file']) }}" target="_blank">Lihat</a>
                                                        </div>
                                                    @endif
                                                </div>

                                                <button type="button" class="btn-remove" onclick="removeRow(this)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-muted small fst-italic mb-2" id="emptyKompetensiMsg">Belum ada data kompetensi.</div>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <button type="button" class="btn-add-pelatihan" onclick="addPelatihanKompetensi()">
                                        <i class="fas fa-plus"></i> Tambah Kompetensi
                                    </button>
                                </div>
                            </div>

                            <div class="button-group">
                                <button type="submit" class="btn-maroon">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('public.pelatihan.index') }}" class="btn-secondary-custom">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Helper untuk menghilangkan pesan "belum ada data" jika baris baru ditambahkan
        function clearEmptyMsg(id) {
            const msg = document.getElementById(id);
            if(msg) msg.remove();
        }

        function addPelatihanDasar() {
            clearEmptyMsg('emptyDasarMsg');
            const container = document.getElementById('pelatihanDasarContainer');
            const item = document.createElement('div');
            item.className = 'pelatihan-item';
            // Animasi masuk sederhana
            item.style.animation = "fadeIn 0.3s";

            item.innerHTML = `
                <input type="text" name="pelatihan_dasar[]" class="form-control" placeholder="Nama Pelatihan" required>
                <input type="number" name="pelatihan_tahun_dasar[]" class="form-control" placeholder="Thn">
                <div class="file-wrapper">
                    <input type="file" name="pelatihan_file_dasar[]" class="form-control">
                    <input type="hidden" name="pelatihan_existing_file_dasar[]" value="">
                </div>
                <button type="button" class="btn-remove" onclick="removeRow(this)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;
            container.appendChild(item);
        }

        function addPelatihanKompetensi() {
            clearEmptyMsg('emptyKompetensiMsg');
            const container = document.getElementById('pelatihanKompetensiContainer');
            const item = document.createElement('div');
            item.className = 'pelatihan-item';
            item.style.animation = "fadeIn 0.3s";

            item.innerHTML = `
                <input type="text" name="pelatihan_kompetensi[]" class="form-control" placeholder="Nama Pelatihan" required>
                <input type="number" name="pelatihan_tahun_kompetensi[]" class="form-control" placeholder="Thn">
                <div class="file-wrapper">
                    <input type="file" name="pelatihan_file_kompetensi[]" class="form-control">
                    <input type="hidden" name="pelatihan_existing_file_kompetensi[]" value="">
                </div>
                <button type="button" class="btn-remove" onclick="removeRow(this)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;
            container.appendChild(item);
        }

        function removeRow(btn) {
            // Konfirmasi penghapusan opsional, di sini langsung hapus
            btn.parentElement.remove();
        }

        // Tambahkan style animasi keyframes di head script
        const styleSheet = document.createElement("style");
        styleSheet.innerText = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(styleSheet);
    </script>

    @endsection
