<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penilaian Presentasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .gradient-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .penilaian-item {
            border-left: 3px solid #667eea;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-header gradient-header text-white py-4">
                        <h3 class="mb-0 text-center">
                            <i class="bi bi-clipboard-check me-2"></i>Form Penilaian Presentasi
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        {{-- Info Mahasiswa --}}
                        <div class="alert alert-info">
                            <h5 class="mb-2"><i class="bi bi-person-circle me-2"></i>Informasi Mahasiswa</h5>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td width="150"><strong>Nama</strong></td>
                                    <td>: {{ $presentasi->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>: {{ $presentasi->user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Judul Penelitian</strong></td>
                                    <td>: {{ $presentasi->praPenelitian->judul }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Presentasi</strong></td>
                                    <td>: {{ $presentasi->tanggal_presentasi->format('d F Y') }}</td>
                                </tr>
                            </table>
                        </div>

                        {{-- File PPT --}}
                        <div class="mb-4">
                            <h5><i class="bi bi-file-earmark-slides me-2"></i>File Presentasi</h5>
                            <a href="{{ Storage::url($presentasi->file_ppt) }}" target="_blank" class="btn btn-primary">
                                <i class="bi bi-download me-1"></i> Download File PPT
                            </a>
                            <small class="d-block mt-2 text-muted">
                                Diupload: {{ $presentasi->uploaded_at->format('d M Y H:i') }}
                            </small>
                        </div>

                        <hr>

                        {{-- Form Penilaian --}}
                        @if ($presentasi->status_penilaian == 'pending')
                            <form action="{{ route('ci.submit-penilaian', $presentasi->id) }}" method="POST" id="formPenilaian">
                                @csrf

                                <h5 class="mb-3"><i class="bi bi-star-fill me-2 text-warning"></i>Penilaian</h5>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Nilai Akhir <span class="text-danger">*</span></label>
                                    <div class="row g-2">
                                        <div class="col-6 col-md-3">
                                            <input type="radio" class="btn-check" name="nilai" id="nilaiA" value="A" required>
                                            <label class="btn btn-outline-success w-100" for="nilaiA">
                                                <h4 class="mb-0">A</h4>
                                                <small>Sangat Baik</small>
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <input type="radio" class="btn-check" name="nilai" id="nilaiB" value="B">
                                            <label class="btn btn-outline-info w-100" for="nilaiB">
                                                <h4 class="mb-0">B</h4>
                                                <small>Baik</small>
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <input type="radio" class="btn-check" name="nilai" id="nilaiC" value="C">
                                            <label class="btn btn-outline-warning w-100" for="nilaiC">
                                                <h4 class="mb-0">C</h4>
                                                <small>Revisi</small>
                                            </label>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <input type="radio" class="btn-check" name="nilai" id="nilaiD" value="D">
                                            <label class="btn btn-outline-danger w-100" for="nilaiD">
                                                <h4 class="mb-0">D</h4>
                                                <small>Ditolak</small>
                                            </label>
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        A/B = Lanjut ke laporan | C = Revisi presentasi | D = Ditolak (ulang dari awal)
                                    </small>
                                </div>

                                <hr>

                                <h5 class="mb-3">Detail Penilaian</h5>
                                <div id="penilaianContainer">
                                    <div class="penilaian-item card mb-3 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">Penilaian 1</h6>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold">Judul/Aspek <span class="text-danger">*</span></label>
                                                <input type="text" name="penilaian[0][judul]" class="form-control" placeholder="Contoh: Metodologi Penelitian" required>
                                            </div>
                                            <div>
                                                <label class="form-label small fw-bold">Keterangan <span class="text-danger">*</span></label>
                                                <textarea name="penilaian[0][keterangan]" rows="3" class="form-control" placeholder="Tulis feedback, saran, atau catatan..." required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mb-4">
                                    <button type="button" class="btn btn-outline-primary" onclick="tambahPenilaian()">
                                        <i class="bi bi-plus-circle me-1"></i> Tambah Penilaian
                                    </button>
                                </div>

                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <strong>Perhatian:</strong> Penilaian yang sudah disubmit tidak dapat diubah. Pastikan semua data sudah benar.
                                </div>

                                <button type="submit" class="btn btn-lg btn-success w-100" onclick="return confirm('Submit penilaian? Penilaian tidak dapat diubah setelah disubmit.')">
                                    <i class="bi bi-send me-2"></i> Submit Penilaian
                                </button>
                            </form>
                        @else
                            {{-- Sudah Dinilai --}}
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <h5 class="mb-2">Penilaian Sudah Disubmit</h5>
                                <p class="mb-0">Nilai: <strong class="fs-4">{{ $presentasi->nilai }}</strong></p>
                            </div>

                            @if ($presentasi->hasil_penilaian)
                                <h5 class="mt-4 mb-3">Detail Penilaian:</h5>
                                @foreach ($presentasi->hasil_penilaian as $index => $item)
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <h6 class="fw-bold text-primary">{{ $index + 1 }}. {{ $item['judul'] }}</h6>
                                            <p class="mb-0">{{ $item['keterangan'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <p class="text-muted mt-3">Dinilai pada: {{ $presentasi->dinilai_at->format('d F Y H:i') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let penilaianCount = 1;

        function tambahPenilaian() {
            const container = document.getElementById('penilaianContainer');
            const newItem = document.createElement('div');
            newItem.className = 'penilaian-item card mb-3 border-0 shadow-sm';
            newItem.innerHTML = `
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Penilaian ${penilaianCount + 1}</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.penilaian-item').remove()">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Judul/Aspek <span class="text-danger">*</span></label>
                        <input type="text" name="penilaian[${penilaianCount}][judul]" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label small fw-bold">Keterangan <span class="text-danger">*</span></label>
                        <textarea name="penilaian[${penilaianCount}][keterangan]" rows="3" class="form-control" required></textarea>
                    </div>
                </div>
            `;
            container.appendChild(newItem);
            penilaianCount++;
        }
    </script>
</body>
</html>