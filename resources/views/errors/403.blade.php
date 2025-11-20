<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Menunggu Persetujuan</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons (Optional for icons) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --maroon: #7c1316;
            --maroon-dark: #5f0f11;
            --white: #ffffff;
            --text-white-50: rgba(255, 255, 255, 0.7);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--maroon);
            /* Latar belakang maroon sesuai tema */
            background-image: radial-gradient(circle at top right, #9d2a2e 0%, var(--maroon) 40%);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            padding: 20px;
            color: var(--white);
            overflow: hidden;
        }

        .container {
            max-width: 600px;
            position: relative;
            z-index: 2;
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        /* Ilustrasi / Logo */
        .illustration-box {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .illustration-box img {
            width: 70px;
            height: auto;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2));
        }

        h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .status-badge {
            background: rgba(255, 255, 255, 0.15);
            color: #ffdfba; /* Warna peach lembut */
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        p {
            font-size: 16px;
            margin-bottom: 35px;
            color: var(--text-white-50);
            font-weight: 300;
            line-height: 1.6;
        }

        /* Buttons */
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-home {
            background: var(--white);
            color: var(--maroon);
            border: 2px solid var(--white);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn-home:hover {
            background: #f0f0f0;
            border-color: #f0f0f0;
            transform: translateY(-2px);
        }

        .btn-contact {
            background: transparent;
            color: var(--white);
            border: 2px solid rgba(255,255,255,0.3);
        }

        .btn-contact:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--white);
            transform: translateY(-2px);
        }

        /* Footer */
        footer {
            margin-top: 40px;
            font-size: 12px;
            color: var(--text-white-50);
        }
        
        footer a {
            color: var(--white);
            text-decoration: none;
            font-weight: 600;
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Background Elements */
        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
            z-index: 1;
        }
        .c1 { width: 300px; height: 300px; top: -100px; left: -100px; }
        .c2 { width: 200px; height: 200px; bottom: 50px; right: -50px; }

        @media (max-width: 576px) {
            h1 { font-size: 28px; }
            p { font-size: 14px; }
            .btn-group { flex-direction: column; width: 100%; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>

<body>

    <!-- Background Decorations -->
    <div class="bg-circle c1"></div>
    <div class="bg-circle c2"></div>

    <div class="container">
        
        <div class="illustration-box">
            <!-- Ganti dengan icon.png Anda -->
            <img src="{{ asset('icon.png') }}" alt="Logo App">
        </div>

        <div class="status-badge">
            <i class="bi bi-hourglass-split"></i> Akun Pending
        </div>

        <h1>Mohon Bersabar...</h1>
        
        <p>
            Akun Anda telah berhasil dibuat, namun saat ini sedang dalam <strong>antrean persetujuan Admin</strong>. 
            <br class="d-none d-md-block">
            Silakan hubungi admin atau cek kembali secara berkala.
        </p>

        <div class="btn-group">
            <!-- Arahkan ke logout agar user bisa login ulang nanti -->
            <a href="{{ route('login') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-home">
                <i class="bi bi-arrow-left"></i> Kembali ke Login
            </a>
            
            <!-- Form Logout Hidden (Wajib ada untuk tombol di atas) -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <!-- Tombol Hubungi Admin (WA Link Contoh) -->
            <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-contact">
                <i class="bi bi-whatsapp"></i> Hubungi Admin
            </a>
        </div>

        <footer>
            &copy; {{ date('Y') }} Masisma App. All rights reserved.
        </footer>
    </div>

</body>
</html>