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
        }

        .certificate-container {
            width: 100%;
            /* [DIHAPUS] height: 100%; (Ini adalah penyebab utama) */
            padding: 40px;
            background-image: url('{{ public_path('icon.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            border: 20px solid #7c1316;
            box-sizing: border-box;
            position: relative;
            
            /* [TAMBAHAN] Membantu DomPDF agar tidak memotong container ini */
            page-break-inside: avoid; 
        }

        .text-center {
            text-align: center;
        }

        .header {
            font-size: 32px;
            font-weight: bold;
            color: #7c1316;
            margin-top: 20px; /* [DIUBAH] Mengurangi margin */
        }

        .sub-header {
            font-size: 24px;
            color: #333;
            margin-top: 10px;
        }

        .presented-to {
            font-size: 18px;
            color: #555;
            margin-top: 30px; /* [DIUBAH] Mengurangi margin */
            margin-bottom: 10px;
        }

        .student-name {
            font-size: 48px;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
        }

        .student-details {
            font-size: 18px;
            color: #444;
            margin-bottom: 25px; /* [DIUBAH] Mengurangi margin */
        }

        .content-body {
            font-size: 20px;
            line-height: 1.6;
            margin-top: 20px; /* [DIUBAH] Mengurangi margin */
        }

        /* [DIUBAH] Mengganti layout float dengan table */
        .footer-signatures {
            margin-top: 40px; /* [DIUBAH] Mengurangi margin */
            width: 100%;
            /* [TAMBAHAN] Pastikan tabel tidak terpotong */
            page-break-inside: avoid; 
        }

        .signature-block {
            width: 50%; /* [DIUBAH] Menggunakan 50% untuk sel tabel */
            text-align: center;
            vertical-align: top;
            padding: 0 20px; /* Memberi jarak antar kolom */
            box-sizing: border-box;
        }

        /* [DIHAPUS] CSS float .left dan .right tidak diperlukan lagi */

        .signature-line {
            border-bottom: 1px solid #000;
            width: 80%;
            margin: 40px auto 5px auto; /* [DIUBAH] Mengurangi margin */
        }
    </style>
</head>

<body>
    <div class="certificate-container">

        <div class="text-center">
            <div class="header">SERTIFIKAT MAGANG</div>
            <div class="sub-header">CERTIFICATE OF COMPLETION</div>
        </div>

        <div class="text-center">
            <div class="presented-to">Diberikan kepada:</div>
            <div class="student-name">{{ $mahasiswa->nm_mahasiswa }}</div>
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
</body>
</html>