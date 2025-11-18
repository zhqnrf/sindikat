@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Pra Penelitian</h2>
    
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between">
            Data Penelitian
            <span class="badge {{ $praPenelitian->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                {{ $praPenelitian->status }}
            </span>
        </div>
        <div class="card-body">
            <p><strong>Judul:</strong> {{ $praPenelitian->judul }}</p>
            <p><strong>Universitas:</strong> {{ $praPenelitian->mou->nama_universitas ?? 'N/A' }}</p>
            <p><strong>Exp MOU:</strong> {{ optional(optional($praPenelitian->mou)->tanggal_keluar)->format('d M Y') ?? 'N/A' }}</p>
            <p><strong>Jenis:</strong> {{ $praPenelitian->jenis_penelitian }}</p>
            <p><strong>Tanggal Mulai:</strong> {{ $praPenelitian->tanggal_mulai ? $praPenelitian->tanggal_mulai->format('d M Y') : 'N/A' }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Daftar Mahasiswa ({{ $praPenelitian->mahasiswas->count() }})</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jenjang</th>
                        <th>No. Telpon (WA)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($praPenelitian->mahasiswas as $mhs)
                    <tr>
                        <td>{{ $mhs->nama }}</td>
                        <td>{{ $mhs->jenjang }}</td>
                        <td>
                            <a href="https://wa.me/+62{{ preg_replace('/[^0-9]/', '', $mhs->no_telpon) }}" target="_blank">
                                {{ $mhs->no_telpon }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <a href="{{ route('pra-penelitian.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection