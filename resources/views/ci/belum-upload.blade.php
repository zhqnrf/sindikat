<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Belum Diupload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg text-center">
                    <div class="card-body p-5">
                        <i class="bi bi-clock-history display-1 text-warning mb-4"></i>
                        <h3 class="fw-bold mb-3">File Presentasi Belum Diupload</h3>
                        <p class="text-muted mb-4">
                            Mahasiswa <strong>{{ $presentasi->user->name }}</strong> belum mengupload file presentasi. 
                            Silakan kembali lagi nanti atau hubungi mahasiswa.
                        </p>
                        <div class="alert alert-info">
                            <small>
                                <strong>Info Presentasi:</strong><br>
                                Tanggal: {{ $presentasi->tanggal_presentasi->format('d F Y') }}<br>
                                Waktu: {{ $presentasi->waktu_mulai }} - {{ $presentasi->waktu_selesai }}<br>
                                Tempat: {{ $presentasi->tempat }}
                            </small>
                        </div>
                        <button onclick="location.reload()" class="btn btn-primary">
                            <i class="bi bi-arrow-clockwise me-1"></i> Refresh Halaman
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>