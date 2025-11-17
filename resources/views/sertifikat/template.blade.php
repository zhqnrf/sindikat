<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sertifikat Penyelesaian Magang</title>
    <style>
        @page {
            margin: 0;
            /* Hapus margin bawaan browser */
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
            height: 100%;
            padding: 40px;
            /* Ganti dengan path ke gambar background sertifikat Anda jika ada */
            /* background-image: url('path/to/your/background.jpg'); */
            background-size: cover;
            background-repeat: no-repeat;
            border: 20px solid #7c1316;
            /* Contoh border tebal */
            box-sizing: border-box;
            position: relative;
        }

        .text-center {
            text-align: center;
        }

        .header {
            font-size: 32px;
            font-weight: bold;
            color: #7c1316;
            margin-top: 50px;
        }

        .sub-header {
            font-size: 24px;
            color: #333;
            margin-top: 10px;
        }

        .presented-to {
            font-size: 18px;
            color: #555;
            margin-top: 60px;
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
            margin-bottom: 40px;
        }

        .content-body {
            font-size: 20px;
            line-height: 1.6;
            margin-top: 30px;
        }

        .footer-signatures {
            margin-top: 80px;
            width: 100%;
        }

        .signature-block {
            width: 40%;
            display: inline-block;
            text-align: center;
        }

        .signature-block.left {
            float: left;
            margin-left: 5%;
        }

        .signature-block.right {
            float: right;
            margin-right: 5%;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 80%;
            margin: 60px auto 5px auto;
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

        <div class="footer-signatures">
            <div class="signature-block left">
                <div>[Jabatan]</div>
                <div class="signature-line"></div>
                <div><strong>[Nama Pembimbing]</strong></div>
            </div>
            <div class="signature-block right">
                <div>Kediri, {{ $tanggal_terbit }}</div>
                <div>[Jabatan, misal: Pimpinan]</div>
                <div class="signature-line"></div>
                <div><strong>[Nama Pimpinan]</strong></div>
            </div>
        </div>

    </div>
</body>

</html>
