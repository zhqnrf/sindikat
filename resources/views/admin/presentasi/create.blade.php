@extends('layouts.app')

@section('title', 'Set Jadwal Presentasi')
@section('page-title', 'Set Jadwal Presentasi')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('admin.pengajuan.show', $pengajuan->id) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Info Mahasiswa --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Informasi Mahasiswa</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Nama</small>
                            <strong>{{ $pengajuan->user->name }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $pengajuan->user->email }}</strong>
                        </div>
                        <div class="col-md-6 mt-3">
                            <small class="text-muted d-block">Universitas</small>
                            <strong>{{ $praPenelitian->mou->nama_universitas ?? '-' }}</strong>
                        </div>
                        <div class="col-md-6 mt-3">
                            <small class="text-muted d-block">Program Studi</small>
                            <strong>{{ $praPenelitian->prodi ?? '-' }}</strong>
                        </div>
                        <div class="col-md-12 mt-3">
                            <small class="text-muted d-block">Judul Penelitian</small>
                            <strong>{{ $praPenelitian->judul ?? '-' }}</strong>
                        </div>
                        <div class="col-md-6 mt-3">
                            <small class="text-muted d-block">Jenis Penelitian</small>
                            <strong>{{ $praPenelitian->jenis_penelitian ?? '-' }}</strong>
                        </div>
                        <div class="col-md-6 mt-3">
                            <small class="text-muted d-block">Tanggal Mulai</small>
                            <strong>{{ \Carbon\Carbon::parse($praPenelitian->tanggal_mulai)->format('d M Y') }}</strong>
                        </div>
                    </div>

                    {{-- Anggota Tim --}}
                    @if ($praPenelitian->anggotas && $praPenelitian->anggotas->count() > 0)
                        <hr class="my-3">
                        <div class="mb-2">
                            <small class="text-muted d-block mb-2"><i class="bi bi-people-fill me-1"></i>Anggota Tim Penelitian:</small>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama</th>
                                        <th>No. Telpon</th>
                                        <th>Jenjang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($praPenelitian->anggotas as $anggota)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $anggota->nama }}</td>
                                            <td>{{ $anggota->no_telpon }}</td>
                                            <td>{{ $anggota->jenjang }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-light mt-3 mb-0 small">
                            <i class="bi bi-info-circle me-1"></i> Tidak ada anggota tim penelitian
                        </div>
                    @endif

                    {{-- Dosen Pembimbing --}}
                    <hr class="my-3">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Dosen Pembimbing 1</small>
                            <strong>{{ $praPenelitian->dosen1_nama }}</strong><br>
                            <small class="text-muted">{{ $praPenelitian->dosen1_hp }}</small>
                        </div>
                        @if ($praPenelitian->dosen2_nama)
                            <div class="col-md-6">
                                <small class="text-muted d-block">Dosen Pembimbing 2</small>
                                <strong>{{ $praPenelitian->dosen2_nama }}</strong><br>
                                <small class="text-muted">{{ $praPenelitian->dosen2_hp }}</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Form Jadwal --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-maroon text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Set Jadwal Presentasi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.presentasi.store', $pengajuan->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Presentasi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_presentasi" class="form-control @error('tanggal_presentasi') is-invalid @enderror" value="{{ old('tanggal_presentasi') }}" required>
                            @error('tanggal_presentasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Waktu Mulai <span class="text-danger">*</span></label>
                                <input type="time" name="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror" value="{{ old('waktu_mulai', '09:00') }}" required>
                                @error('waktu_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Waktu Selesai <span class="text-danger">*</span></label>
                                <input type="time" name="waktu_selesai" class="form-control @error('waktu_selesai') is-invalid @enderror" value="{{ old('waktu_selesai', '11:00') }}" required>
                                @error('waktu_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tempat <span class="text-danger">*</span></label>
                            <input type="text" name="tempat" class="form-control @error('tempat') is-invalid @enderror" value="{{ old('tempat', $pengajuan->ruangan ?? '') }}" placeholder="Contoh: Ruang 301" required>
                            @error('tempat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan_admin" rows="4" class="form-control" placeholder="Catatan tambahan untuk mahasiswa (opsional)">{{ old('keterangan_admin') }}</textarea>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Link untuk CI:</strong><br>
                            Link penilaian akan digenerate otomatis dan bisa dilihat di halaman detail presentasi.
                        </div>

                        <button type="submit" class="btn btn-maroon" onclick="return confirm('Kirim jadwal presentasi ke mahasiswa?')">
                            <i class="bi bi-send me-1"></i> Kirim Jadwal Presentasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection