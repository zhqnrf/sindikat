@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Pengajuan Pra Penelitian</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- 
        PERHATIKAN: 
        Parameter di Laravel 7 Anda mungkin {pra_penelitian} (dengan garis bawah) 
        sesuai file routes.php Anda. Jika $praPenelitian tidak ditemukan,
        ganti $praPenelitian menjadi $pra_penelitian di seluruh file ini.
    --}}
    <form action="{{ route('pra-penelitian.update', $praPenelitian) }}" method="POST">
        @csrf
        @method('PUT')
        
        {{-- Data Penelitian Utama --}}
        <div class="card mb-3">
            <div class="card-header">Data Penelitian</div>
            <div class="card-body">
                {{-- ... (Field Judul, MOU, Jenis, Tanggal Mulai tetap sama) ... --}}
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Pra Penelitian</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $praPenelitian->judul) }}" required>
                </div>
                <div class="mb-3">
                    <label for="mou_id" class="form-label">Universitas (MOU)</label>
                    <select name="mou_id" id="mou_id" class="form-select" required>
                        <option value="">Pilih Universitas</option>
                        @foreach($mous as $mou)
                            <option value="{{ $mou->id }}" {{ old('mou_id', $praPenelitian->mou_id) == $mou->id ? 'selected' : '' }}>
                                {{ $mou->nama_universitas }} (Exp: {{ $mou->tanggal_keluar->format('d M Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jenis_penelitian" class="form-label">Jenis Penelitian</label>
                    <select name="jenis_penelitian" id="jenis_penelitian" class="form-select" required>
                        <option value="Data Awal" {{ old('jenis_penelitian', $praPenelitian->jenis_penelitian) == 'Data Awal' ? 'selected' : '' }}>Data Awal</option>
                        <option value="Uji Validitas" {{ old('jenis_penelitian', $praPenelitian->jenis_penelitian) == 'Uji Validitas' ? 'selected' : '' }}>Uji Validitas</option>
                        <option value="Penelitian" {{ old('jenis_penelitian', $praPenelitian->jenis_penelitian) == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai Penelitian</label>
                    {{-- Pastikan $praPenelitian->tanggal_mulai sudah di-cast di Model --}}
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $praPenelitian->tanggal_mulai ? $praPenelitian->tanggal_mulai->format('Y-m-d') : '') }}" required>
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
                    @php
                        $mahasiswaData = old('mahasiswas', $praPenelitian->mahasiswas->map(function($mhs) {
                            return ['nama' => $mhs->nama, 'no_telpon' => $mhs->no_telpon, 'jenjang' => $mhs->jenjang];
                        })->toArray());
                    @endphp

                    @foreach($mahasiswaData as $i => $mhs)
                    <div class="row g-3 mb-2 align-items-center mahasiswa-row">
                        <div class="col-md-3"><input type="text" name="mahasiswas[{{ $i }}][nama]" class="form-control" placeholder="Nama Mahasiswa" value="{{ $mhs['nama'] }}" required></div>
                        
                        {{-- PERUBAHAN DI SINI: Input Group untuk No Telpon --}}
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                {{-- 
                                    Kita tetap mengisi 'value' dengan data lengkap (misal +62812...)
                                    Script JS di bawah akan membersihkannya secara otomatis saat halaman dimuat.
                                --}}
                                <input type="tel" name="mahasiswas[{{ $i }}][no_telpon]" class="form-control" 
                                       placeholder="812..." value="{{ $mhs['no_telpon'] }}" required>
                            </div>
                        </div>
                        {{-- AKHIR PERUBAHAN --}}

                        <div class="col-md-3"><input type="text" name="mahasiswas[{{ $i }}][jenjang]" class="form-control" placeholder="Jenjang (S1/D3/S2)" value="{{ $mhs['jenjang'] }}" required></div>
                        <div class="col-md-3"><button type="button" class="btn btn-sm btn-danger hapus-mahasiswa">Hapus</button></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Pengajuan</button>
    </form>
</div>

{{-- Template (sama seperti di create.blade.php) --}}
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

@endsection

@push('scripts')
{{-- 
    PERUBAHAN SCRIPT: 
    Script ini sama persis dengan script di 'create.blade.php'.
    Script ini sudah bisa menangani data yang ada (membersihkan +62)
    dan data yang baru ditambahkan.
--}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const list = document.getElementById('mahasiswa-list');
    const addButton = document.getElementById('tambah-mahasiswa');
    const template = document.getElementById('mahasiswa-template');
    
    // Set index awal berdasarkan data yang sudah ada
    let index = {{ count($mahasiswaData) }}; 

    // --- FUNGSI BARU UNTUK FORMATTING ---
    function formatPhoneNumber(input) {
        let value = input.value;
        // 1. Hapus '0' di awal
        if (value.startsWith('0')) {
            value = value.substring(1);
        }
        // 2. Hapus '+62' di awal (dari database atau 'old')
        if (value.startsWith('+62')) {
            value = value.substring(3);
        }
        // 3. Hapus spasi/strip/karakter non-digit
        value = value.replace(/[^0-9]/g, '');
        input.value = value;
    }

    // --- EVENT DELEGATION UNTUK INPUT BARU ---
    list.addEventListener('input', function(e) {
        if (e.target && e.target.name && e.target.name.includes('[no_telpon]')) {
            formatPhoneNumber(e.target);
        }
    });

    // --- BERSIHKAN INPUT YANG SUDAH ADA (SAAT LOAD) ---
    // Ini adalah bagian penting untuk halaman 'edit'
    document.querySelectorAll('input[name*="[no_telpon]"]').forEach(function(input) {
        formatPhoneNumber(input);
    });
    
    // --- KODE LAMA UNTUK TAMBAH BARIS ---
    addButton.addEventListener('click', function() {
        let newRowHtml = template.innerHTML.replace(/INDEX/g, index);
        let newRow = document.createElement('div');
        newRow.innerHTML = newRowHtml;
        list.appendChild(newRow.firstElementChild);
        index++;
    });

    // --- KODE LAMA UNTUK HAPUS BARIS ---
    list.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('hapus-mahasiswa')) {
            if (list.getElementsByClassName('mahasiswa-row').length > 1) {
                e.target.closest('.mahasiswa-row').remove();
            } else {
                alert('Minimal harus ada 1 mahasiswa.');
            }
        }
    });
});
</script>
@endpush