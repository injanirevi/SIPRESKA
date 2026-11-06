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
                            Username (NIM/NIP)
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
                        <label for="password" class="form-label">
                            Kata Sandi
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            autocomplete="current-password"
                            placeholder="Masukkan kata sandi"
                            required
                        >

                        @error('password')
                            <div class="invalid-feedback">
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
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit" class="btn btn-brand w-100">
                        Masuk
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
</body>
</html>

