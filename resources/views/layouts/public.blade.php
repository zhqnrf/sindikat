<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Interaktif')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icon Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Choices.js CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/choices.js/1.1.6/styles/css/choices.min.css"
        integrity="sha512-+8K1k6gM6+6a2r9oQwB+8u8Zxq2u1Jp0xFhZkq6Ykq1F0s3rVw1Z3QXw6k3Qw6s1y2z7x7Y9G6q2K1M1Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Chart.js untuk visualisasi data --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: "Inter", sans-serif;
            background: #f5f6fa;
        }

        .main-container {
            width: 100%;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 18px;
        }

        /* Smooth Animation */
        * {
            transition: 0.25s ease;
        }

        @media(max-width: 480px) {
            body {
                padding: 8px;
            }
        }
    </style>
</head>

<body>

    <div class="main-container">
        @yield('content')
    </div>
    
    <div class="modal fade" id="notepadModal" tabindex="-1" aria-labelledby="notepadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notepadModalLabel">📝 Notepad Pribadi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">Catatan ini disimpan di browser Anda (LocalStorage) dan tidak disimpan
                        ke server.</p>
                    <div id="notepad-editor"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="clear-notepad" class="btn btn-danger">Bersihkan Catatan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Choices.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/choices.js/1.1.6/choices.min.js"
        integrity="sha512-+kq1Zk6gM6+6a2r9oQwB+8u8Zxq2u1Jp0xFhZkq6Ykq1F0s3rVw1Z3QXw6k3Qw6s1y2z7x7Y9G6q2K1M1Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        // Pastikan script ini dijalankan setelah DOM siap
        document.addEventListener('DOMContentLoaded', function() {

            // Cek jika elemen modal dan editor ada
            const notepadModal = document.getElementById('notepadModal');
            const editorElement = document.getElementById('notepad-editor');

            if (notepadModal && editorElement) {

                let quill;
                const storageKey = 'userNotepadContent';

                // Inisialisasi Quill saat modal DITAMPILKAN
                // Ini penting agar ukurannya tidak kacau
                notepadModal.addEventListener('shown.bs.modal', function() {
                    if (!quill) { // Hanya inisialisasi sekali
                        quill = new Quill('#notepad-editor', {
                            theme: 'snow',
                            modules: {
                                toolbar: [
                                    [{
                                        'header': [1, 2, 3, false]
                                    }],
                                    ['bold', 'italic', 'underline', 'strike'],
                                    [{
                                        'list': 'ordered'
                                    }, {
                                        'list': 'bullet'
                                    }],
                                    ['link', 'blockquote'],
                                    ['clean']
                                ]
                            }
                        });

                        // 1. Muat data dari LocalStorage saat Quill siap
                        const savedContent = localStorage.getItem(storageKey);
                        if (savedContent) {
                            try {
                                // Konten Quill disimpan sebagai JSON (Delta)
                                quill.setContents(JSON.parse(savedContent));
                            } catch (e) {
                                // Jika gagal parse (mungkin data lama/string biasa)
                                quill.setText(savedContent);
                            }
                        }

                        // 2. Simpan data ke LocalStorage setiap ada perubahan
                        quill.on('text-change', function(delta, oldDelta, source) {
                            if (source == 'user') {
                                // Simpan sebagai JSON Delta untuk mempertahankan format
                                localStorage.setItem(storageKey, JSON.stringify(quill
                                    .getContents()));
                            }
                        });
                    }
                });

                // 3. Tombol untuk membersihkan catatan
                const clearButton = document.getElementById('clear-notepad');
                if (clearButton) {
                    clearButton.addEventListener('click', function() {
                        if (confirm('Yakin ingin menghapus semua isi notepad?')) {
                            if (quill) {
                                quill.setContents([]); // Kosongkan editor
                            }
                            localStorage.removeItem(storageKey); // Hapus dari storage
                        }
                    });
                }
            }
        });
    </script>
    @yield('scripts')
</body>

</html>
