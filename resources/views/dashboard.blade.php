<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard - SIPRESKA</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f7fb;
            color: #1f2937;
        }


        /* =========================
           LAYOUT
        ========================== */

        .layout {
            min-height: 100vh;
            display: flex;
        }


        /* =========================
           SIDEBAR
        ========================== */

        .sidebar {
            width: 240px;

            background: white;

            border-right: 1px solid #e5e7eb;

            position: fixed;

            top: 0;
            left: 0;
            bottom: 0;

            padding: 25px 20px;
        }


        .logo {
            font-size: 24px;

            font-weight: bold;

            color: #2563eb;

            padding: 0 10px;

            margin-bottom: 40px;
        }


        .menu {
            display: flex;

            flex-direction: column;

            gap: 4px;
        }


        .menu a {
            display: block;

            padding: 12px 10px;

            color: #374151;

            text-decoration: none;

            border-radius: 7px;

            transition: 0.2s;
        }


        .menu a:hover {
            background: #eff6ff;

            color: #2563eb;
        }


        .menu a.active {
            color: #2563eb;

            background: #eff6ff;

            font-weight: bold;
        }


        /* =========================
           LOGOUT
        ========================== */

        .logout {
            position: absolute;

            bottom: 25px;

            left: 20px;

            right: 20px;

            border-top: 1px solid #e5e7eb;

            padding-top: 18px;
        }


        .logout button {
            width: 100%;

            border: none;

            background: transparent;

            text-align: left;

            padding: 12px 10px;

            color: #dc2626;

            border-radius: 7px;

            cursor: pointer;

            font-size: 15px;
        }


        .logout button:hover {
            background: #fef2f2;
        }


        /* =========================
           CONTENT
        ========================== */

        .content {
            margin-left: 240px;

            width: calc(100% - 240px);

            padding: 35px;
        }


        .header {
            background: white;

            padding: 25px;

            border-radius: 12px;

            border: 1px solid #e5e7eb;

            margin-bottom: 25px;
        }


        .header h1 {
            margin-bottom: 8px;

            font-size: 28px;
        }


        .header p {
            color: #64748b;
        }


        /* =========================
           CARD
        ========================== */

        .cards {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;
        }


        .card {
            background: white;

            padding: 25px;

            border-radius: 12px;

            border: 1px solid #e5e7eb;
        }


        .card h3 {
            margin-bottom: 10px;
        }


        .card .number {
            font-size: 30px;

            font-weight: bold;

            color: #2563eb;

            margin-bottom: 8px;
        }


        .card p {
            color: #64748b;

            line-height: 1.5;
        }


        /* =========================
           MOBILE
        ========================== */

        @media (max-width: 800px) {

            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 200px;

                width: calc(100% - 200px);

                padding: 20px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 600px) {

            .layout {
                display: block;
            }

            .sidebar {
                position: relative;

                width: 100%;

                height: auto;
            }

            .logout {
                position: static;

                margin-top: 20px;
            }

            .content {
                margin-left: 0;

                width: 100%;
            }

        }

    </style>

</head>


<body>


<div class="layout">


    <!-- SIDEBAR -->

    <aside class="sidebar">

        <div class="logo">
            SIPRESKA
        </div>


        <nav class="menu">

            <a href="/dashboard"
               class="active">

                Dashboard

            </a>


            <a href="/prestasi">

                Prestasi

            </a>


            <a href="/pengajuan">

                Pengajuan Prestasi

            </a>


            <a href="/profil">

                Profil

            </a>

        </nav>


        <div class="logout">

            <form action="/logout"
                  method="POST">

                @csrf

                <button type="submit">

                    Logout

                </button>

            </form>

        </div>

    </aside>



    <!-- CONTENT -->

    <main class="content">


        <div class="header">

            <h1>
                Dashboard
            </h1>

            <p>
                Selamat datang di SIPRESKA.
            </p>

        </div>



        <div class="cards">


            <div class="card">

                <h3>
                    Total Prestasi
                </h3>

                <div class="number">
                    0
                </div>

                <p>
                    Data masih menggunakan dummy.
                </p>

            </div>


            <div class="card">

                <h3>
                    Menunggu Verifikasi
                </h3>

                <div class="number">
                    0
                </div>

                <p>
                    Data masih menggunakan dummy.
                </p>

            </div>


            <div class="card">

                <h3>
                    Prestasi Disetujui
                </h3>

                <div class="number">
                    0
                </div>

                <p>
                    Data masih menggunakan dummy.
                </p>

            </div>


        </div>


    </main>


</div>


</body>
</html>