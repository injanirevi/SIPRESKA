<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | SIPRESKA</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 32px 16px;
            background:
                radial-gradient(ellipse at 12% 12%, rgba(201, 162, 39, .09), transparent 34%),
                radial-gradient(ellipse at 88% 86%, rgba(128, 88, 184, .13), transparent 40%),
                linear-gradient(135deg, #fff 0%, #f8f5fc 52%, #eee6f7 100%);
            color: #273047;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 460px;
            border: 1px solid rgba(231, 224, 240, .95);
            border-top: 4px solid #C9A227;
            border-radius: 20px;
            background: #FFFFFF;
            box-shadow: 0 24px 70px rgba(57, 38, 83, .12) !important;
        }

        .brand-title {
            background: linear-gradient(
                90deg,
                #8058B8 0%,
                #5B3A8E 55%,
                #432765 100%
            );
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: 1px;
        }

        .brand-subtitle {
            font-size: 14px;
            line-height: 1.6;
        }

        .form-label {
            color: #273047;
            font-weight: 500;
        }

        .form-control {
            min-height: 49px;
            border: 1px solid #D8D2E2;
            border-radius: 10px;
            padding: 11px 14px;
        }

        .form-control:focus {
            border-color: #5B3A8E;
            box-shadow: 0 0 0 3px rgba(91, 58, 142, 0.12);
        }

        .btn-brand {
            min-height: 49px;
            background: linear-gradient(
                135deg,
                #8058B8 0%,
                #5B3A8E 55%,
                #432765 100%
            );
            border: 1px solid #5B3A8E;
            border-radius: 10px;
            color: #FFFFFF;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .btn-brand:hover {
            background: linear-gradient(
                135deg,
                #6C46A2 0%,
                #472D70 100%
            );
            border-color: #472D70;
            color: #FFFFFF;
        }

        .brand-link {
            color: #5B3A8E;
            font-weight: 600;
            text-decoration: none;
        }

        .brand-link:hover {
            color: #472D70;
            text-decoration: underline;
        }

        .form-check-input:checked {
            background-color: #5B3A8E;
            border-color: #5B3A8E;
        }

        .form-check-input:focus {
            border-color: #5B3A8E;
            box-shadow: 0 0 0 3px rgba(91, 58, 142, 0.12);
        }

        .gold-divider {
            width: 42px;
            height: 3px;
            margin: 12px auto 18px;
            background: #C9A227;
            border-radius: 10px;
        }

        /* Captcha Security Check Container (AICIS Style) */
        .captcha-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            border: 1px solid #D8D2E2;
            border-radius: 10px;
            background: #FFFFFF;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.02);
            gap: 10px;
        }

        .captcha-image-wrapper {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: #FFFFFF;
            cursor: pointer;
            user-select: none;
        }

        .captcha-image-wrapper img {
            height: 52px;
            max-width: 100%;
            display: block;
            object-fit: contain;
            transition: transform 0.15s ease;
        }

        .captcha-image-wrapper:hover img {
            transform: scale(1.02);
        }

        .btn-refresh-captcha {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            border: 1px solid #E2D9EE;
            background: #FAF7FD;
            color: #5B3A8E;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-refresh-captcha:hover {
            background: #5B3A8E;
            color: #FFFFFF;
            border-color: #5B3A8E;
            transform: rotate(35deg);
        }

        .password-toggle-wrapper {
            position: relative;
        }

        .password-toggle-wrapper .form-control {
            padding-right: 44px;
        }

        .btn-toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #718096;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
        }

        .btn-toggle-password:hover {
            color: #5B3A8E;
        }

        @media (max-width: 480px) {
            .login-card {
                border-radius: 16px;
            }
        }
    </style>
</head>

<body class="d-flex align-items-center py-5">
    <main class="container">
        <section class="card login-card shadow-lg mx-auto">
            <div class="card-body p-4 p-md-5">

                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo.png') }}?v={{ filemtime(public_path('images/logo.png')) }}" alt="Logo SIPRESKA" width="72" height="72" class="mb-3" style="object-fit: contain; filter: drop-shadow(0 8px 18px rgba(67, 39, 101, 0.16));">
                    <h1 class="h3 fw-bold brand-title mb-0">
                        SIPRESKA
                    </h1>

                    <div class="gold-divider"></div>

                    <p class="text-secondary brand-subtitle mb-0">
                        Sistem Informasi Pendataan dan Pengelolaan
                        Prestasi Sivitas Akademika
                    </p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('login.process') }}"
                >
                    @csrf

                    <div class="mb-3">
                        <label for="username" class="form-label">
                            Email Address / Username (NIM/NIP) <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            class="form-control @error('username') is-invalid @enderror"
                            autocomplete="username"
                            placeholder="Masukkan NIM atau NIP"
                            required
                            autofocus
                        >

                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label mb-0">
                                Password <span class="text-danger">*</span>
                            </label>
                        </div>

                        <div class="password-toggle-wrapper">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                required
                            >
                            <button
                                type="button"
                                class="btn-toggle-password"
                                onclick="togglePasswordVisibility()"
                                aria-label="Tampilkan atau sembunyikan password"
                                title="Lihat password"
                            >
                                <svg id="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>

                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- SECURITY CHECK / CAPTCHA (Ala AICIS UINSSC) -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label mb-0" style="font-weight: 600;">
                                Security Check <span class="text-danger">*</span>
                            </label>
                            <span class="text-muted" style="font-size: 11.5px;">Klik untuk ganti</span>
                        </div>

                        <div class="captcha-box mb-2">
                            <div class="captcha-image-wrapper" onclick="refreshCaptcha()" title="Klik untuk memuat kode baru">
                                <img
                                    id="captcha-image"
                                    src="{{ route('captcha') }}?v={{ time() }}"
                                    alt="Security Captcha"
                                >
                            </div>
                            <button
                                type="button"
                                class="btn-refresh-captcha"
                                onclick="refreshCaptcha()"
                                title="Ganti kode captcha"
                                aria-label="Ganti kode captcha"
                            >
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/>
                                </svg>
                            </button>
                        </div>

                        <label for="captcha" class="form-label mb-1" style="font-size: 13.5px; font-weight: 500;">
                            Enter Captcha <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            id="captcha"
                            name="captcha"
                            class="form-control @error('captcha') is-invalid @enderror"
                            placeholder="Type the code above"
                            autocomplete="off"
                            required
                        >

                        @error('captcha')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-check mb-4">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="remember"
                            id="remember"
                            value="1"
                            @checked(old('remember'))
                        >

                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="btn btn-brand w-100">
                        Sign in
                    </button>
                </form>

                <p class="text-center mt-4 mb-0">
                    <a href="{{ route('home') }}" class="brand-link">
                        ← Kembali ke Beranda
                    </a>
                </p>

            </div>
        </section>
    </main>

    <script>
        function refreshCaptcha() {
            var img = document.getElementById('captcha-image');
            if (img) {
                img.src = '{{ route('captcha') }}?v=' + Date.now();
            }
        }

        function togglePasswordVisibility() {
            var passInput = document.getElementById('password');
            var eyeIcon = document.getElementById('eye-icon');
            if (!passInput || !eyeIcon) return;

            if (passInput.type === 'password') {
                passInput.type = 'text';
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                passInput.type = 'password';
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }
    </script>
</body>
</html>
