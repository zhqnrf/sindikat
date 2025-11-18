{{-- Ganti dengan layout utama Anda --}}
@extends('layouts.app') 

@section('content')
<div class="container">
    <h2>Daftar Pra Penelitian</h2>
    <a href="{{ route('pra-penelitian.create') }}" class="btn btn-primary mb-3">Tambah Pengajuan</a>

    {{-- Tampilkan notifikasi success/error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <li class="nav-item">
    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#notepadModal" title="Notepad">
        <i class="fas fa-sticky-note"></i> </a>
</li>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Penelitian</th>
                    <th>Universitas</th>
                    <th>Exp. MOU</th>
                    <th>Tgl Mulai</th>
                    <th>Jml Mhs</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penelitian as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->mou->nama_universitas ?? 'N/A' }}</td>
                        {{-- Asumsi kolom exp date di tabel MOU adalah 'tanggal_keluar' --}}
                        <td>{{ $item->mou->tanggal_keluar->format('d M Y') ?? 'N/A' }}</td> 
                        <td>{{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d M Y') : 'N/A' }}</td>
                        <td>{{ $item->mahasiswas_count }}</td>
                        <td>
                            <span class="badge {{ $item->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pra-penelitian.show', $item) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('pra-penelitian.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                            
                            {{-- Form untuk Hapus --}}
                            <form action="{{ route('pra-penelitian.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                            
                            {{-- Form untuk Batal --}}
                            @if($item->status == 'Aktif')
                            <form action="{{ route('pra-penelitian.batal', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin batalkan penelitian ini?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-secondary">Batalkan</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $penelitian->links() }}
</div>
@endsection