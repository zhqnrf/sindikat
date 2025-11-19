@extends('layouts.app')

@section('title', 'Detail Pra Penelitian')
@section('page-title', 'Detail Pra Penelitian')

@section('content')
    <style>
        :root {
            --custom-maroon: #7c1316;
            --custom-maroon-light: #a3191d;
            --custom-maroon-subtle: #fcf0f1;
            --text-dark: #2c3e50;
            --text-muted: #95a5a6;
            --card-radius: 12px;
            --shadow-soft: 0 4px 20px rgba(0, 0, 0, 0.05);
            --transition: 0.3s ease;
        }

        .header-section {
            background: linear-gradient(135deg, var(--custom-maroon), var(--custom-maroon-light));
            color: white;
            border-radius: var(--card-radius);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .header-title-group h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }

        .header-subtitle {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-custom {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-edit {
            background-color: #e3f2fd;
            color: #1565c0;
        }

        .btn-edit:hover {
            background-color: #bbdefb;
        }

        .btn-back {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-back:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .detail-card {
            background: #fff;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow-soft);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .detail-card-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid var(--custom-maroon);
            padding: 1.5rem;
        }

        .detail-card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--custom-maroon);
            margin: 0;
        }

        .detail-card-body {
            padding: 2rem;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 2rem;
            margin-bottom: 1.5rem;
            align-items: start;
        }

        @media (max-width: 768px) {
            .detail-row {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .detail-value {
            color: var(--text-dark);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .detail-value.empty {
            color: var(--text-muted);
            font-style: italic;
        }

        /* Ini adalah style .pelatihan-badge dari target, kita gunakan untuk status */
        .pelatihan-badge {
            background-color: #e3f2fd;
            color: #1565c0;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            display: inline-flex; /* Diubah agar pas */
            width: auto; /* Diubah agar pas */
            align-items: center;
            gap: 0.5rem; /* Tambahan untuk ikon */
        }

        .divider {
            border-bottom: 1px solid #e9ecef;
            margin: 1.5rem 0;
        }

        /* Style untuk table (opsional, tapi agar lebih rapi) */
        .table {
            margin-bottom: 0;
        }
        .table thead th {
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.9rem;
            border-bottom-width: 2px;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: var(--custom-maroon-subtle);
        }
        .text-center.empty {
            color: var(--text-muted);
            font-style: italic;
            padding: 1.5rem;
        }
    </style>

    <div class="header-section">
        <div class="header-content">
            <div class="header-title-group">
                <h1>
                    <i class="fas fa-flask"></i> {{-- Ganti ikon jika perlu --}}
                    Detail Pra Penelitian
                </h1>
                <p class="header-subtitle">
                    {{ $praPenelitian->judul }}
                </p>
            </div>
            <div class="header-actions">
                {{-- Asumsi ada route edit, sesuaikan jika perlu --}}
                <a href="{{ route('pra-penelitian.edit', $praPenelitian->id) }}" class="btn-custom btn-edit">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <a href="{{ route('pra-penelitian.index') }}" class="btn-custom btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-header">
            <h2 class="detail-card-title">
                <i class="fas fa-info-circle"></i>
                Informasi Penelitian
            </h2>
        </div>
        <div class="detail-card-body">

            <div class="detail-row">
                <div class="detail-label">Judul</div>
                <div class="detail-value">
                    <strong>{{ $praPenelitian->judul }}</strong>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    {{-- Menggunakan style badge yang mirip dari file target --}}
                    @if ($praPenelitian->status == 'Aktif')
                        <span class="pelatihan-badge" style="background-color: #d1fae5; color: #065f46;">
                            <i class="fas fa-check-circle"></i>
                            {{ $praPenelitian->status }}
                        </span>
                    @else
                        <span class="pelatihan-badge" style="background-color: #fef2f2; color: #b91c1c;">
                            <i class="fas fa-times-circle"></i>
                            {{ $praPenelitian->status }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Jenis Penelitian</div>
                <div class="detail-value">
                    {{ $praPenelitian->jenis_penelitian }}
                </div>
            </div>

            <div class="divider"></div>

            <div class="detail-row">
                <div class="detail-label">Universitas</div>
                <div class="detail-value {{ empty($praPenelitian->mou->nama_universitas) ? 'empty' : '' }}">
                    {{ $praPenelitian->mou->nama_universitas ?? 'N/A' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Masa Berlaku MOU</div>
                <div class="detail-value {{ empty($praPenelitian->mou->tanggal_keluar) ? 'empty' : '' }}">
                    {{ optional(optional($praPenelitian->mou)->tanggal_keluar)->format('d M Y') ?? 'N/A' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Tanggal Mulai</div>
                <div class="detail-value {{ empty($praPenelitian->tanggal_mulai) ? 'empty' : '' }}">
                    {{ $praPenelitian->tanggal_mulai ? $praPenelitian->tanggal_mulai->format('d M Y') : 'N/A' }}
                </div>
            </div>

        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-header">
            <h2 class="detail-card-title">
                <i class="fas fa-users"></i>
                Daftar Mahasiswa ({{ $praPenelitian->mahasiswas->count() }})
            </h2>
        </div>
        <div class="detail-card-body" style="padding: 0;"> {{-- Hapus padding agar table-responsive pas --}}
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jenjang</th>
                            <th>No. Telpon (WA)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($praPenelitian->mahasiswas as $mhs)
                        <tr>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->jenjang }}</td>
                            <td>
                                <a href="https://wa.me/+62{{ preg_replace('/[^0-9]/', '', $mhs->no_telpon) }}" target="_blank">
                                    {{ $mhs->no_telpon }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center empty">
                                <i class="fas fa-inbox"></i>
                                Belum ada data mahasiswa
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-header">
            <h2 class="detail-card-title">
                <i class="fas fa-clock"></i>
                Informasi Lainnya
            </h2>
        </div>
        <div class="detail-card-body">
            <div class="detail-row">
                <div class="detail-label">Dibuat Pada</div>
                <div class="detail-value">
                    {{ $praPenelitian->created_at->format('d M Y H:i') }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Terakhir Diperbarui</div>
                <div class="detail-value">
                    {{ $praPenelitian->updated_at->format('d M Y H:i') }}
                </div>
            </div>
        </div>
    </div>

@endsection
