<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sertifikat Penyelesaian Magang</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: #fdfdfd;
            color: #333;
        }

        .container {
            width: 100%;
            height: 100%;
            position: relative;
            background-repeat: no-repeat;
            page-break-inside: avoid;
            box-sizing: border-box;
        }

        /* === BAGIAN HEADER (MAROON) === */
        .header-bar {
            background: #7c1316;
            color: #ffffff;
            padding: 30px 50px;
            text-align: center;
            position: relative;
            height: 160px;
            box-sizing: border-box;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .logo-container {
            margin-bottom: 15px;
        }

        .logo {
            width: 80px;
            height: auto;
            filter: brightness(0) invert(1); /* Membuat logo putih */
        }

        .logo-text {
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 1px;
            opacity: 0.8;
            margin-bottom: 10px;
        }

        .header {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
            padding: 10px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.7);
            border-bottom: 1px solid rgba(255, 255, 255, 0.7);
            display: inline-block;
        }

        .sub-header {
            font-size: 20px;
            font-weight: 300;
            margin-top: 5px;
            opacity: 0.9;
        }

        /* === BAGIAN KONTEN UTAMA (PUTIH) === */
        .main-content {
            padding: 30px 60px;
            text-align: center;
            position: relative;
            box-sizing: border-box;
        }

        .presented-to {
            font-size: 16px;
            color: #777;
            margin-top: 20px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .student-name {
            font-size: 48px;
            font-weight: bold;
            color: #7c1316;
            margin-bottom: 10px;
            font-family: 'Georgia', serif;
            font-style: italic;
        }

        .name-line {
            width: 40%;
            margin: 0 auto 20px auto;
            border-bottom: 1px solid #ddd;
        }

        .student-details {
            font-size: 16px;
            color: #555;
            margin-bottom: 25px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .content-body {
            font-size: 18px;
            line-height: 1.5;
            margin-top: 20px;
            color: #444;
            max-width: 700px;
            margin: 20px auto 0 auto;
        }

        /* === BAGIAN TANDA TANGAN (FOOTER) === */
        .footer-signatures {
            margin-top: 30px;
            width: 100%;
            page-break-inside: avoid;
        }

        .signature-block {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 20px;
            box-sizing: border-box;
            font-size: 14px;
            color: #333;
        }

        .signature-line {
            border-bottom: 1px solid #555;
            width: 70%;
            margin: 50px auto 10px auto;
        }

        /* === DEKORASI SUDUT (Grafis Geometris) === */
        .corner-shape {
            position: absolute;
            z-index: 10;
        }

        /* Sudut Kiri Atas */
        .corner-shape.top-left {
            top: 0;
            left: 0;
            width: 100px;
            height: 100px;
            background: #A13A3E;
        }
        .corner-shape.top-left::after {
            content: '';
            position: absolute;
            top: 15px;
            left: 15px;
            width: 20px;
            height: 20px;
            background: #F5E8E8;
        }

        /* Sudut Kanan Atas */
        .corner-shape.top-right {
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: #A13A3E;
        }
         .corner-shape.top-right::after {
            content: '';
            position: absolute;
            top: 15px;
            right: 15px;
            width: 20px;
            height: 20px;
            background: #F5E8E8;
        }

        /* Sudut Kiri Bawah */
        .corner-shape.bottom-left {
            bottom: 0;
            left: 0;
            width: 80px;
            height: 80px;
            background: #B74145;
        }

        /* Sudut Kanan Bawah */
        .corner-shape.bottom-right {
            bottom: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: #B74145;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="corner-shape top-left"></div>
        <div class="corner-shape top-right"></div>
        <div class="corner-shape bottom-left"></div>
        <div class="corner-shape bottom-right"></div>

        <div class="header-bar">
            <!-- Logo RSUD SLG di tengah -->
            <div class="logo-container">
                <img src="https://rsudslg.kedirikab.go.id/asset_compro/img/logo/Logo.png" alt="Logo RSUD SLG" class="logo">
            </div>

            <div class="logo-text">RSUD SIMPANG LIMA GUMUL KEDIRI</div>

            <div class="header">SERTIFIKAT MAGANG</div>
            <div class="sub-header">CERTIFICATE OF COMPLETION</div>
        </div>

        <div class="main-content">

            <div class="text-center">
                <div class="presented-to">Diberikan kepada:</div>
                <div class="student-name">{{ $mahasiswa->nm_mahasiswa }}</div>
                <div class="name-line"></div>

                <div class="student-details">
                    Dari {{ $mahasiswa->univ_asal ?? 'Universitas' }}
                    @if ($mahasiswa->prodi)
                        ({{ $mahasiswa->prodi }})
                    @endif
                </div>
            </div>

            <div class="content-body text-center">
                Telah menyelesaikan program magang di <b>RSUD Simpang Lima Gumul Kediri</b>
                <br>
                dimulai dari tanggal {{ $mahasiswa->tanggal_mulai->isoFormat('D MMMM YYYY') }}
                sampai dengan {{ $mahasiswa->tanggal_berakhir->isoFormat('D MMMM YYYY') }}.
                <br>
                <br>
                Mahasiswa yang bersangkutan telah menyelesaikan program dengan
                <strong>{{ $percentage }}% partisipasi</strong>.
            </div>

            <table class="footer-signatures" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="signature-block">
                        <div>[Jabatan]</div>
                        <div class="signature-line"></div>
                        <div><strong>[Nama Pembimbing]</strong></div>
                    </td>
                    <td class="signature-block">
                        <div>Kediri, {{ $tanggal_terbit }}</div>
                        <div>[Jabatan, misal: Pimpinan]</div>
                        <div class="signature-line"></div>
                        <div><strong>[Nama Pimpinan]</strong></div>
                    </td>
                </tr>
            </table>

        </div>
    </div>
</body>
</html>
