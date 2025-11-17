@extends('layouts.app')

@section('title', 'Ringkasan Sertifikat')
@section('page-title', 'Ringkasan Sertifikat')

@section('content')
    <style>
        :root {
            --custom-maroon: #7c1316;
            --text-dark: #2c3e50;
            --text-muted: #64748b;
            --card-radius: 16px;
            
            --success: #059669;
            --success-bg: #d1fae5;
            --danger: #dc2626;
            --danger-bg: #fee2e2;
            --info: #0284c7;
            --info-bg: #e0f2fe;
        }

        .summary-card, .profile-card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: #fff;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .profile-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .avatar-content {
            width: 60px;
            height: 60px;
            background-color: var(--custom-maroon-subtle);
            color: var(--custom-maroon);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            float: left;
            margin-right: 1rem;
        }

        .info-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 600;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1rem;
        }

        .stat-box {
            text-align: center;
            padding: 1.5rem;
            border-radius: 12px;
            background: #f8f9fa;
        }
        
        .stat-box .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
        }
        
        .stat-box .stat-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .stat-box.success { background-color: var(--success-bg); color: var(--success); }
        .stat-box.danger  { background-color: var(--danger-bg);  color: var(--danger); }
        .stat-box.info    { background-color: var(--info-bg);    color: var(--info); }

        .progress-bar-wrapper {
            background-color: #e9ecef;
            border-radius: 50px;
            height: 20px;
            overflow: hidden;
            position: relative;
        }
        .progress-bar-inner {
            background: linear-gradient(90deg, var(--success), #34d399);
            height: 100%;
            border-radius: 50px;
            transition: width 0.5s ease;
        }
        .progress-bar-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-weight: bold;
            font-size: 0.8rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.4);
        }
        
        /* [BARU] Style untuk Link Shareable */
        .share-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }
        .link-wrapper {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
        .link-text {
            font-family: monospace;
            color: var(--custom-maroon);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .animate-up {
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            opacity: 0; transform: translateY(20px);
        }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="row justify-content-center animate-up">
        <div class="col-md-10 col-lg-8">
            
            <div class="profile-card">
                <div class="profile-header d-flex align-items-center">
                    <div class="avatar-content">
                        {{ strtoupper(substr($mahasiswa->nm_mahasiswa, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: var(--text-dark);">{{ $mahasiswa->nm_mahasiswa }}</h4>
                        <span class="text-muted">{{ $mahasiswa->univ_asal ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="summary-card">
                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold mb-4 text-center">Ringkasan Partisipasi Magang</h5>

                    <div class="stat-grid mb-4">
                        <div class="stat-box info">
                            <div class="stat-value">{{ $totalExpectedDays }}</div>
                            <div class="stat-label">Total Hari Kerja</div>
                        </div>
                        <div class="stat-box success">
                            <div class="stat-value">{{ $totalActualDays }}</div>
                            <div class="stat-label">Total Hari Hadir</div>
                        </div>
                        <div class="stat-box danger">
                            <div class="stat-value">{{ $totalAlpaDays }}</div>
                            <div class="stat-label">Total Hari Alpa</div>
                        </div>
                    </div>
                    
                    <div class="info-group text-center mb-4">
                        <div class="info-label mb-2">Persentase Partisipasi (Otomatis)</div>
                        <div class="progress-bar-wrapper">
                            <div class="progress-bar-inner" style="width: {{ $participationRate }}%;"></div>
                            <span class="progress-bar-label">{{ $participationRate }}%</span>
                        </div>
                    </div>
                    
                    @if($mahasiswa->weekend_aktif)
                        <div class="alert alert-info text-center small">
                            <i class="bi bi-info-circle-fill me-1"></i> 
                            Perhitungan ini mencakup hari Sabtu & Minggu (Weekend Aktif).
                        </div>
                    @else
                        <div class="alert alert-secondary text-center small">
                            <i class="bi bi-info-circle-fill me-1"></i> 
                            Perhitungan ini tidak termasuk hari Sabtu & Minggu.
                        </div>
                    @endif

                    <hr class="my-4">

                    <form action="{{ route('mahasiswa.sertifikat', $mahasiswa->id) }}" method="GET" target="_blank">
                        <div class="mb-3">
                            <label for="override_percentage" class="form-label fw-bold">
                                <i class="bi bi-pencil-fill me-1"></i> Override Persentase (Opsional)
                            </label>
                            <input type="number" step="0.1" min="0" max="100" class="form-control" 
                                   name="override_percentage" id="override_percentage" 
                                   placeholder="Contoh: 95.5 (Kosongkan untuk pakai nilai otomatis)">
                            <small class="text-muted">Isi jika Anda ingin mengganti nilai partisipasi di PDF secara manual.</small>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('mahasiswa.index') }}" class="btn btn-light border rounded-pill px-4">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </a>
                            
                            @if (now()->gt($mahasiswa->tanggal_berakhir))
                                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                                    <i class="bi bi-file-earmark-pdf-fill me-2"></i> Generate Sertifikat
                                </button>
                            @else
                                <button class="btn btn-secondary rounded-pill px-4" disabled>
                                    <i class="bi bi-lock-fill me-2"></i> Sertifikat Belum Tersedia
                                </button>
                            @endif
                        </div>
                    </form>
                    @if (now()->gt($mahasiswa->tanggal_berakhir))
                        <div class="share-box mt-4">
                            <h6 class="fw-bold mb-3 text-dark d-flex align-items-center">
                                <i class="bi bi-send-fill me-2 text-secondary"></i> Link Download Publik
                            </h6>
                            <label class="small text-muted mb-1">Salin link ini untuk dibagikan ke mahasiswa:</label>
                            <div class="link-wrapper">
                                <span class="link-text flex-grow-1" id="sertifikatLink">
                                    {{ route('sertifikat.download', $mahasiswa->share_token) }}
                                </span>
                                <button class="btn btn-sm btn-light border" onclick="copyLink('sertifikatLink')" title="Salin Link">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                    </div>
            </div>

        </div>
    </div>

    <script>
        function copyLink(elementId) {
            const linkText = document.getElementById(elementId).innerText;
            
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(linkText).then(() => {
                    alert("Link berhasil disalin!");
                }).catch(err => {
                    fallbackCopy(linkText);
                });
            } else {
                fallbackCopy(linkText);
            }
        }

        function fallbackCopy(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                alert("Link berhasil disalin!");
            } catch (err) {
                alert("Gagal menyalin link.");
            }
            document.body.removeChild(textArea);
        }
    </script>
@endsection