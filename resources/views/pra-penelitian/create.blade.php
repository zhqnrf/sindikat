@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Pengajuan Pra Penelitian</h2>

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pra-penelitian.store') }}" method="POST">
            @csrf

            {{-- Data Penelitian Utama --}}
            <div class="card mb-3">
                <div class="card-header">Data Penelitian</div>
                <div class="card-body">
                    {{-- ... (Field Judul, MOU, Jenis, Tanggal Mulai tetap sama) ... --}}
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Pra Penelitian</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="mou_id" class="form-label">Universitas (MOU)</label>
                        <select name="mou_id" id="mou_id" class="form-select" required>
                            <option value="">Pilih Universitas</option>
                            @foreach ($mous as $mou)
                                <option value="{{ $mou->id }}" {{ old('mou_id') == $mou->id ? 'selected' : '' }}>
                                    {{ $mou->nama_universitas }} (Exp: {{ $mou->tanggal_keluar->format('d M Y') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_penelitian" class="form-label">Jenis Penelitian</label>
                        <select name="jenis_penelitian" id="jenis_penelitian" class="form-select" required>
                            <option value="Data Awal" {{ old('jenis_penelitian') == 'Data Awal' ? 'selected' : '' }}>Data
                                Awal</option>
                            <option value="Uji Validitas"
                                {{ old('jenis_penelitian') == 'Uji Validitas' ? 'selected' : '' }}>Uji Validitas</option>
                            <option value="Penelitian" {{ old('jenis_penelitian') == 'Penelitian' ? 'selected' : '' }}>
                                Penelitian</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai Penelitian</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                            value="{{ old('tanggal_mulai') }}" required>
                    </div>
                </div>
            </div>

            {{-- Data Mahasiswa Dinamis --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Data Mahasiswa
                    <button type="button" id="tambah-mahasiswa" class="btn btn-sm btn-success">Tambah Mahasiswa</button>
                </div>
                <div class="card-body">
                    <div id="mahasiswa-list">

                        @if (old('mahasiswas'))
                            @foreach (old('mahasiswas') as $i => $mhs)
                                <div class="row g-3 mb-2 align-items-center mahasiswa-row">
                                    <div class="col-md-3"><input type="text"
                                            name="mahasiswas[{{ $i }}][nama]" class="form-control"
                                            placeholder="Nama Mahasiswa" value="{{ $mhs['nama'] }}" required></div>
                                    
                                    {{-- PERUBAHAN DI SINI: Input Group untuk No Telpon --}}
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text">+62</span>
                                            <input type="tel" name="mahasiswas[{{ $i }}][no_telpon]" class="form-control"
                                                   placeholder="812..." value="{{ $mhs['no_telpon'] }}" required>
                                        </div>
                                    </div>
                                    {{-- AKHIR PERUBAHAN --}}

                                    <div class="col-md-3"><input type="text"
                                            name="mahasiswas[{{ $i }}][jenjang]" class="form-control"
                                            placeholder="Jenjang (S1/D3/S2)" value="{{ $mhs['jenjang'] }}" required></div>
                                    <div class="col-md-3"><button type="button"
                                            class="btn btn-sm btn-danger hapus-mahasiswa">Hapus</button></div>
                                </div>
                            @endforeach
                        @else
                            {{-- Baris pertama default --}}
                            <div class="row g-3 mb-2 align-items-center mahasiswa-row">
                                <div class="col-md-3"><input type="text" name="mahasiswas[0][nama]" class="form-control"
                                        placeholder="Nama Mahasiswa" required></div>
                                
                                {{-- PERUBAHAN DI SINI: Input Group untuk No Telpon --}}
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-text">+62</span>
                                        <input type="tel" name="mahasiswas[0][no_telpon]" class="form-control"
                                               placeholder="812..." required>
                                    </div>
                                </div>
                                {{-- AKHIR PERUBAHAN --}}

                                <div class="col-md-3"><input type="text" name="mahasiswas[0][jenjang]"
                                        class="form-control" placeholder="Jenjang (S1/D3/S2)" required></div>
                                <div class="col-md-3"><button type="button"
                                        class="btn btn-sm btn-danger hapus-mahasiswa">Hapus</button></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Pengajuan</button>
        </form>
    </div>

    {{-- Template untuk baris baru (disembunyikan) --}}
    <template id="mahasiswa-template">
        <div class="row g-3 mb-2 align-items-center mahasiswa-row">
            <div class="col-md-3"><input type="text" name="mahasiswas[INDEX][nama]" class="form-control"
                    placeholder="Nama Mahasiswa" required></div>
            
            {{-- PERUBAHAN DI SINI: Input Group untuk No Telpon --}}
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text">+62</span>
                    <input type="tel" name="mahasiswas[INDEX][no_telpon]" class="form-control"
                           placeholder="812..." required>
                </div>
            </div>
            {{-- AKHIR PERUBAHAN --}}

            <div class="col-md-3"><input type="text" name="mahasiswas[INDEX][jenjang]" class="form-control"
                    placeholder="Jenjang (S1/D3/S2)" required></div>
            <div class="col-md-3"><button type="button" class="btn btn-sm btn-danger hapus-mahasiswa">Hapus</button>
            </div>
        </div>
    </template>


    {{-- 
        PERUBAHAN SCRIPT: 
        Kita tambahkan fungsi 'formatPhoneNumber' dan mendaftarkannya 
        agar otomatis membersihkan input.
    --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const list = document.getElementById('mahasiswa-list');
            const addButton = document.getElementById('tambah-mahasiswa');
            const template = document.getElementById('mahasiswa-template');
            let index = {{ old('mahasiswas') ? count(old('mahasiswas')) : 1 }};

            // --- FUNGSI BARU UNTUK FORMATTING ---
            function formatPhoneNumber(input) {
                let value = input.value;
                // 1. Hapus '0' di awal
                if (value.startsWith('0')) {
                    value = value.substring(1);
                }
                // 2. Hapus '+62' di awal (jika terlanjur dipaste atau dari data 'old')
                if (value.startsWith('+62')) {
                    value = value.substring(3);
                }
                // 3. Hapus spasi/strip/karakter non-digit
                value = value.replace(/[^0-9]/g, '');
                input.value = value;
            }

            // --- EVENT DELEGATION UNTUK INPUT BARU ---
            // Ini akan memformat nomor saat user mengetik di input mana pun (baru atau lama)
            list.addEventListener('input', function(e) {
                if (e.target && e.target.name && e.target.name.includes('[no_telpon]')) {
                    formatPhoneNumber(e.target);
                }
            });

            // --- BERSIHKAN INPUT YANG SUDAH ADA (SAAT LOAD) ---
            // Ini penting untuk data 'old' yang mungkin masih mengandung '0' atau '+62'
            document.querySelectorAll('input[name*="[no_telpon]"]').forEach(function(input) {
                formatPhoneNumber(input);
            });
            
            // --- KODE LAMA ANDA UNTUK TAMBAH BARIS ---
            addButton.addEventListener('click', function() {
                // Ambil HTML dari template
                let newRowHtml = template.innerHTML.replace(/INDEX/g, index);

                // Buat div baru dan masukkan HTML
                let newRow = document.createElement('div');
                newRow.innerHTML = newRowHtml;

                // Ambil elemen baris pertama dari div baru
                list.appendChild(newRow.firstElementChild);

                index++;
            });

            // --- KODE LAMA ANDA UNTUK HAPUS BARIS ---
            list.addEventListener('click', function(e) {
                // Event delegation untuk tombol hapus
                if (e.target && e.target.classList.contains('hapus-mahasiswa')) {
                    // Cek agar tidak menghapus baris terakhir
                    if (list.getElementsByClassName('mahasiswa-row').length > 1) {
                        e.target.closest('.mahasiswa-row').remove();
                    } else {
                        alert('Minimal harus ada 1 mahasiswa.');
                    }
                }
            });
        });
    </script>
@endsection