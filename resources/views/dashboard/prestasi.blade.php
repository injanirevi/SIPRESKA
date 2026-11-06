<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Prestasi Admin | SIPRESKA</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar,
        .sidebar * {
            font-family: Arial, sans-serif;
        }

        :root {
            --purple: #5B3A8E;
            --deep: #432765;
            --lavender: #EEE6F8;
            --gold: #C9A227;
            --text: #342847;
            --muted: #80758F;
            --border: #E7DFF0;
            --card-bg: #FFFFFF;
        }

        body {
            margin: 0;
            color: var(--text);
            background:
                radial-gradient(circle at 90% 5%, rgba(197,165,233,.22), transparent 30%),
                linear-gradient(135deg, #FFFFFF, #F8F5FC 48%, #EEE5F8);
            min-height: 100vh;
        }

        .layout {
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 250px;
            height: 100vh;
            padding: 28px 20px;
            background: rgba(255,255,255,.98);
            border-right: 1px solid var(--border);
            z-index: 100;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            box-shadow: 5px 0 25px rgba(67,39,101,.035);
        }

        .logo {
            padding: 0 10px;
            font-size: 25px;
            font-weight: 800;
            background: linear-gradient(90deg,#8058B8,#5B3A8E,#432765);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .logo small {
            display: block;
            margin-top: 8px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 400;
            line-height: 1.7;
        }

        .gold-line {
            width: 45px;
            height: 3px;
            flex-shrink: 0;
            margin: 17px 10px 30px;
            border-radius: 4px;
            background: var(--gold);
        }

        .menu-title {
            margin: 0 10px 12px;
            color: #A096AF;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.4px;
        }

        .menu {
            display: grid;
            gap: 8px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: 1px solid transparent;
            border-radius: 9px;
            color: #665A77;
            font-size: 13px;
            text-decoration: none;
            transition: background .2s, color .2s;
        }

        .menu a:hover,
        .menu a.active {
            color: var(--purple);
            background: linear-gradient(110deg,#F3EEF9,#E7DCF5);
        }

        .menu a.active {
            border-color: #DED0EE;
            box-shadow: inset 3px 0 var(--purple);
            font-weight: 700;
        }

        .menu-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            border-radius: 7px;
            background: #F5F0FA;
            color: var(--purple);
            font-size: 15px;
        }

        .menu a.active .menu-icon {
            background: #FFFFFF;
        }

        .sidebar-counter-badge {
            margin-left: auto;
            padding: 2px 7px;
            border-radius: 999px;
            background: var(--gold, #C9A227);
            color: #FFFFFF;
            font-size: 10px;
            font-weight: 800;
            line-height: 1.2;
            box-shadow: 0 2px 6px rgba(201, 162, 39, 0.35);
        }

        .logout {
            margin-top: auto;
            padding-top: 15px;
            border-top: 1px solid var(--border);
        }

        .logout button {
            width: 100%;
            padding: 12px;
            border: 0;
            border-radius: 9px;
            background: transparent;
            color: #AC4655;
            text-align: left;
            cursor: pointer;
            font-size: 13px;
            transition: background .2s;
        }

        .logout button:hover {
            background: #FFF1F2;
        }

        /* MAIN CONTENT */
        .content {
            width: calc(100% - 250px);
            margin-left: 250px;
            padding: 36px 40px;
            min-width: 0;
        }

        .welcome {
            margin-bottom: 24px;
            padding: 24px 28px;
            border: 1px solid #E4D7F2;
            border-left: 5px solid var(--gold);
            border-radius: 15px;
            background: linear-gradient(115deg,#fff,#F0E7FB 55%,#E5D6F6);
            box-shadow: 0 8px 25px rgba(67,39,101,.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .welcome-text {
            max-width: 650px;
        }

        .eyebrow {
            margin-bottom: 8px;
            color: #8864B1;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        h1 {
            margin: 0 0 8px;
            color: var(--deep);
            font-size: 27px;
        }

        .welcome p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        /* EXPORT DROPDOWN */
        .export-dropdown-wrapper {
            position: relative;
            display: inline-block;
        }

        .export-main-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            border: 1px solid #D5C2ED;
            border-radius: 10px;
            background: linear-gradient(135deg, #7A53B3, #5B3A8E);
            color: #FFFFFF;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(91,58,142,.2);
            transition: transform .15s, box-shadow .15s, background .2s;
        }

        .export-main-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 9px 22px rgba(91,58,142,.3);
            background: linear-gradient(135deg, #6C44A7, #482A75);
        }

        .export-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 290px;
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 14px 35px rgba(67,39,101,.15);
            padding: 8px;
            z-index: 1000;
        }

        .export-menu.show {
            display: block;
            animation: fadeIn .15s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .export-menu-title {
            padding: 8px 12px 6px;
            color: #A096AF;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .export-menu a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            border-radius: 8px;
            color: var(--text);
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: background .15s, color .15s;
        }

        .export-menu a:hover {
            background: #F4EEFA;
            color: var(--purple);
        }

        .export-menu a span.tag {
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            background: #EFE7F8;
            color: var(--purple);
            font-weight: 700;
        }

        .export-menu-divider {
            height: 1px;
            background: var(--border);
            margin: 6px 0;
        }

        /* STATS CARDS (RINGKASAN DATA - DESAIN KARTU BERSIH & RAPI) */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        @media (max-width: 1100px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .stats {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            min-width: 0;
            padding: 20px 22px;
            border: 1px solid #ECE4F4;
            border-radius: 14px;
            background: #FFFFFF;
            box-shadow: 0 4px 16px rgba(67, 39, 101, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(67, 39, 101, 0.08);
            border-color: #DCCFE8;
        }

        .stat-card-action.has-pending {
            background: #FFFFFF;
            border-color: #F1E2BF;
            box-shadow: 0 4px 16px rgba(201, 162, 39, 0.07);
        }

        .stat-card-action.has-pending:hover {
            border-color: #E2C784;
            box-shadow: 0 10px 24px rgba(201, 162, 39, 0.12);
        }

        .stat-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 14px;
        }

        .stat-label {
            color: #6C5E7F;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: -0.1px;
        }

        .stat-status-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.2;
            white-space: nowrap;
        }

        .stat-status-badge.pending {
            background: #FFF4DC;
            color: #9A6C05;
            border: 1px solid #F8DE9E;
        }

        .stat-status-badge.success {
            background: #EDF7F1;
            color: #1E7E45;
            border: 1px solid #CEEBD7;
        }

        .stat-status-badge.neutral {
            background: #F4EFF9;
            color: #6C528D;
            border: 1px solid #E6DCF1;
        }

        .stat-status-badge.danger {
            background: #FDF2F2;
            color: #B91C1C;
            border: 1px solid #FACDCD;
        }

        .stat-number {
            color: #2D1A47;
            font-size: 30px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
            overflow-wrap: anywhere;
        }

        .stat-number-pending {
            color: #B47805 !important;
        }

        .stat-number-approved {
            color: #1E824C !important;
        }

        .stat-note {
            color: #8C7F9E;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.4;
        }

        .stat-card-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #9A6C05;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.15s ease, transform 0.15s ease;
        }

        .stat-card-link:hover {
            color: #694801;
            transform: translateX(2px);
        }
        /* MAIN PANEL */
        .panel {
            padding: 26px 28px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: rgba(255,255,255,.98);
            box-shadow: 0 8px 28px rgba(67,39,101,.045);
        }

        .panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
        }

        .panel-title {
            margin: 0 0 6px;
            color: var(--deep);
            font-size: 20px;
            font-weight: 800;
        }

        .panel-subtitle {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .list-counter {
            padding: 6px 12px;
            border-radius: 20px;
            background: #F4EFFA;
            color: var(--purple);
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* SEARCH BAR & FILTERS */
        .search-filter-box {
            background: #FAF7FE;
            border: 1px solid #EAE1F5;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 22px;
        }

        .search-main-row {
            position: relative;
            margin-bottom: 12px;
        }

        .search-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-icon {
            position: absolute;
            left: 14px;
            color: #8C7C9E;
            font-size: 15px;
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 13px 16px 13px 40px;
            border: 1px solid #DDD1EA;
            border-radius: 10px;
            background: #FFFFFF;
            color: var(--text);
            font-size: 13px;
            transition: border-color .2s, box-shadow .2s;
        }

        .search-input:focus {
            outline: 0;
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(91,58,142,.12);
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
        }

        .filter-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #DDD1EA;
            border-radius: 9px;
            background: #FFFFFF;
            color: var(--text);
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: border-color .2s;
        }

        .filter-select:focus {
            outline: 0;
            border-color: var(--purple);
        }

        .filter-reset-btn {
            padding: 10px 14px;
            border: 1px solid #E5DBF0;
            border-radius: 9px;
            background: #FFFFFF;
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, color .2s;
        }

        .filter-reset-btn:hover {
            background: #FFF1F2;
            color: #B64B57;
            border-color: #F8D3D6;
        }

        /* MODERN DATA TABLE (SUPER RAPI, PRESISI & TERSTRUKTUR) */
        .admin-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #ECE3F5;
            border-radius: 13px;
            background: #FFFFFF;
            box-shadow: 0 3px 12px rgba(67, 39, 101, 0.035);
        }

        .admin-prestasi-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        .admin-prestasi-table thead {
            background: #FAF8FD;
            border-bottom: 1px solid #ECE3F5;
        }

        .admin-prestasi-table th {
            padding: 13px 18px;
            font-size: 11px;
            font-weight: 700;
            color: #6C5B82;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            white-space: nowrap;
        }

        .admin-prestasi-table tbody tr {
            border-bottom: 1px solid #F3EDF8;
            transition: background 0.15s ease;
        }

        .admin-prestasi-table tbody tr:last-child {
            border-bottom: none;
        }

        .admin-prestasi-table tbody tr:hover {
            background: #FCFAFF;
        }

        .admin-prestasi-table td {
            padding: 14px 18px;
            vertical-align: middle;
        }

        .table-prestasi-title {
            font-size: 14px;
            font-weight: 700;
            color: #2D1A47;
            line-height: 1.35;
            margin-bottom: 4px;
            overflow-wrap: anywhere;
        }

        .table-prestasi-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
            font-size: 11.5px;
            color: #7E7092;
        }

        .badge-capaian-tag {
            display: inline-flex;
            align-items: center;
            padding: 1.5px 6.5px;
            border-radius: 4px;
            background: #F1E9F9;
            color: var(--purple);
            font-size: 11px;
            font-weight: 700;
        }

        .meta-separator {
            color: #CFC2DD;
            font-size: 11px;
        }

        .table-user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .table-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #F2ECFA;
            color: var(--purple);
            font-weight: 800;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid #E4D7F3;
        }

        .table-user-info {
            min-width: 0;
        }

        .table-user-name {
            font-size: 13px;
            font-weight: 700;
            color: #2D1A47;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table-user-sub {
            font-size: 11px;
            color: #8C7E9E;
            margin-top: 1px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* STATUS BADGE DENGAN TITIK INDIKATOR RATA KIRI */
        .status-badge-modern {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 700;
            line-height: 1.3;
            white-space: nowrap;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .status-badge-modern.status-menunggu_verifikasi {
            background: #FFF8E6;
            color: #975A00;
            border: 1px solid #FFE4A0;
        }

        .status-badge-modern.status-menunggu_verifikasi .status-dot {
            background: #F59E0B;
        }

        .status-badge-modern.status-disetujui {
            background: #EDF9F1;
            color: #157A3C;
            border: 1px solid #C4ECCF;
        }

        .status-badge-modern.status-disetujui .status-dot {
            background: #10B981;
        }

        .status-badge-modern.status-ditolak {
            background: #FDF2F2;
            color: #B91C1C;
            border: 1px solid #FACDCD;
        }

        .status-badge-modern.status-ditolak .status-dot {
            background: #EF4444;
        }

        .status-badge-modern.status-perlu_perbaikan {
            background: #FFF7E6;
            color: #9C6500;
            border: 1px solid #FFE7B3;
        }

        .status-badge-modern.status-perlu_perbaikan .status-dot {
            background: #EAB308;
        }

        /* TOMBOL AKSI SERAGAM LEBAR PERSIS 145PX */
        .btn-row-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 145px;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s ease, border-color 0.15s ease, transform 0.15s ease, box-shadow 0.15s ease;
            white-space: nowrap;
            box-sizing: border-box;
            background: #FFFFFF;
            border: 1px solid #D8CBE6;
            color: var(--purple);
        }

        .btn-row-action:hover {
            background: #F6F0FD;
            border-color: var(--purple);
            transform: translateY(-1px);
        }

        .btn-row-action.highlight {
            background: linear-gradient(135deg, #7A53B3, #5B3A8E);
            border: 1px solid transparent;
            color: #FFFFFF;
            box-shadow: 0 2px 8px rgba(91, 58, 142, 0.2);
        }

        .btn-row-action.highlight:hover {
            background: linear-gradient(135deg, #6C44A7, #482A75);
            box-shadow: 0 4px 12px rgba(91, 58, 142, 0.3);
            color: #FFFFFF;
        }

        /* MODAL DETAIL PRESTASI (LUAS, LAPANG, BERSIH, TIDAK MEPET) */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(36, 27, 49, 0.65);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            overflow-y: auto;
        }

        .modal-overlay.active {
            display: flex;
            animation: modalFadeIn .2s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-card {
            background: #FFFFFF;
            border-radius: 18px;
            box-shadow: 0 24px 60px rgba(54, 28, 87, 0.28);
            width: 100%;
            max-width: 860px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
            border: 1px solid #ECE2F5;
        }

        .modal-header {
            padding: 24px 30px 20px;
            border-bottom: 1px solid #ECE4F4;
            background: #FAF8FD;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }

        .modal-header-main {
            flex: 1;
            min-width: 0;
        }

        .modal-eyebrow {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.2px;
            color: #8C6FA8;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .modal-header-title {
            margin: 0 0 10px;
            font-size: 20px;
            color: #2D1A47;
            font-weight: 800;
            letter-spacing: -0.3px;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .modal-header-status {
            display: flex;
            align-items: center;
        }

        .modal-close-btn {
            background: #FFFFFF;
            border: 1px solid #DCD0EA;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            color: #6C5D80;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .15s, color .15s, border-color .15s;
            flex-shrink: 0;
        }

        .modal-close-btn:hover {
            background: #FFF1F2;
            color: #D63031;
            border-color: #F8B4B4;
        }

        .modal-body {
            padding: 26px 30px;
            overflow-y: auto;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .modal-profile-strip {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            background: #FAF7FD;
            border-radius: 12px;
            border: 1px solid #ECE1F6;
        }

        .modal-profile-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8E65C9, #5B3A8E);
            color: #FFFFFF;
            font-weight: 800;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(91, 58, 142, 0.2);
        }

        .modal-profile-name {
            font-size: 14.5px;
            font-weight: 700;
            color: #2D1A47;
        }

        .modal-profile-meta {
            font-size: 12px;
            color: #7B6D8F;
            margin-top: 3px;
            line-height: 1.5;
        }

        .modal-submission-date {
            margin-left: auto;
            font-size: 11.5px;
            color: #8F81A3;
            font-weight: 600;
            white-space: nowrap;
        }

        .modal-team-strip {
            padding: 12px 18px;
            background: #FCFAFF;
            border: 1px dashed #DACEE8;
            border-radius: 10px;
            font-size: 12.5px;
            color: #433256;
            line-height: 1.5;
        }

        .modal-section-clean {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .modal-clean-title {
            font-size: 11.5px;
            font-weight: 800;
            color: #6E538E;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #F2ECFA;
        }

        .modal-clean-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px 20px;
        }

        @media (max-width: 768px) {
            .modal-clean-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 500px) {
            .modal-clean-grid {
                grid-template-columns: 1fr;
            }
        }

        .modal-grid-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .modal-item-label {
            font-size: 11px;
            font-weight: 600;
            color: #8C7E9E;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .modal-item-val {
            font-size: 13.5px;
            font-weight: 700;
            color: #2D1A47;
            line-height: 1.45;
            overflow-wrap: anywhere;
        }

        .modal-item-val.highlight-capaian {
            color: var(--purple);
            font-weight: 800;
        }

        .modal-clean-desc {
            font-size: 13px;
            line-height: 1.7;
            color: #4A3E5C;
            white-space: pre-line;
            background: #FAF8FE;
            padding: 16px 18px;
            border-radius: 12px;
            border: 1px solid #EBE2F4;
        }

        .modal-evidence-list-spacious {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .modal-evidence-item-spacious {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 18px;
            border-radius: 10px;
            background: #FAF8FE;
            border: 1px solid #ECE2F5;
            transition: border-color .15s, background .15s;
        }

        .modal-evidence-item-spacious:hover {
            background: #F6F0FD;
            border-color: #DCCFE8;
        }

        .evidence-item-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .evidence-file-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #EFE7F8;
            color: var(--purple);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .evidence-file-title {
            font-size: 13px;
            font-weight: 700;
            color: #2D1A47;
            overflow-wrap: anywhere;
        }

        .evidence-file-kind {
            font-size: 11px;
            color: #8C7E9E;
            margin-top: 2px;
        }

        .btn-open-doc {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            background: #FFFFFF;
            border: 1px solid #D5C6E6;
            color: var(--purple);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            transition: background .15s, border-color .15s;
        }

        .btn-open-doc:hover {
            background: #F1E9F9;
            border-color: var(--purple);
        }

        .modal-footer {
            padding: 18px 30px;
            border-top: 1px solid #ECE4F4;
            background: #FAF9FE;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-modal-dismiss {
            padding: 9px 20px;
            border-radius: 8px;
            border: 1px solid #D5C8E4;
            background: #FFFFFF;
            color: #5B3A8E;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-modal-dismiss:hover {
            background: #F4EEFB;
            border-color: #5B3A8E;
        }

        .btn-modal-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 22px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(135deg, #7A53B3, #5B3A8E);
            color: #FFFFFF;
            font-size: 12.5px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(91, 58, 142, 0.25);
            transition: all .15s;
        }

        .btn-modal-action:hover {
            background: linear-gradient(135deg, #6B43A6, #4A2B78);
            transform: translateY(-1px);
        }
        /* EMPTY STATE */
        .empty-search-state {
            padding: 45px 20px;
            border: 1px dashed #D4C3E7;
            border-radius: 14px;
            background: #FCFAFE;
            color: var(--muted);
            text-align: center;
            font-size: 13px;
            line-height: 1.8;
        }

        .empty-search-state h3 {
            margin: 0 0 6px;
            color: var(--deep);
            font-size: 17px;
        }

        /* RESPONSIVE */
        @media (max-width: 950px) {
            .content {
                width: calc(100% - 210px);
                margin-left: 210px;
                padding: 24px 20px;
            }

            .sidebar {
                width: 210px;
            }

            .stats {
                grid-template-columns: repeat(2, minmax(0,1fr));
            }

            .filters-grid {
                grid-template-columns: repeat(2, minmax(0,1fr));
            }
        }

        @media (max-width: 720px) {
            .layout { display: block; }
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: 0;
                padding: 20px;
            }
            .content {
                width: 100%;
                margin: 0;
                padding: 20px 16px;
            }
            .stats { grid-template-columns: 1fr; }
            .filters-grid { grid-template-columns: 1fr; }

            .welcome {
                flex-direction: column;
                align-items: flex-start;
            }
            .export-dropdown-wrapper {
                width: 100%;
            }
            .export-main-btn {
                width: 100%;
                justify-content: center;
            }
            .export-menu {
                left: 0;
                right: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    {{-- SIDEBAR ADMIN --}}
    <aside class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SIPRESKA" width="34" height="36" style="display: block; margin-bottom: 8px; object-fit: contain;">
            SIPRESKA
            <small>
                Sistem Informasi Pendataan dan Pengelolaan
                Prestasi Sivitas Akademika
            </small>
        </div>

        <div class="gold-line"></div>
        <div class="menu-title">MENU ADMIN</div>

        <nav class="menu">
            <a href="{{ route('dashboard') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </span>
                Dashboard
            </a>
            <a href="{{ route('admin.prestasi.index') }}" class="active">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </span>
                Daftar Prestasi
            </a>
            <a href="{{ route('admin.verifikasi.index') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </span>
                <span style="flex: 1;">Verifikasi Prestasi</span>
                @php
                    $badgePendingCount = rescue(fn() => \App\Models\Prestasi::where('status', 'menunggu_verifikasi')->count(), 0, false);
                @endphp
                @if ($badgePendingCount > 0)
                    <span class="sidebar-counter-badge">{{ $badgePendingCount }}</span>
                @endif
            </a>
            @if(auth()->user()?->role === 'super_admin')
            <a href="{{ route('superadmin.users.index') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </span>
                Manajemen Akun
            </a>
            @endif
            <a href="{{ route('admin.panduan') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </span>
                Panduan Penggunaan
            </a>
        </nav>

        <div class="logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Keluar dari Akun</button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="content">

        @php
            $totalMenunggu = $prestasis->where('status', 'menunggu_verifikasi')->count();
            $totalDisetujui = $prestasis->where('status', 'disetujui')->count();
            $totalDitolak = $prestasis->where('status', 'ditolak')->count();
        @endphp

        {{-- WELCOME & EXPORT HEADER --}}
        <section class="welcome">
            <div class="welcome-text">
                <div class="eyebrow">PENGELOLAAN DATA PRESTASI</div>
                <h1>Daftar Prestasi Sivitas</h1>
                <p>
                    Pantau dan kelola seluruh prestasi sivitas akademika lengkap dengan pencarian nama peserta, filter tingkat, serta ekspor data sistem.
                </p>
            </div>

            <div class="export-dropdown-wrapper">
                <button type="button" class="export-main-btn" id="exportDropdownTrigger" aria-expanded="false">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Ekspor Data Sistem</span>
                    <span>▾</span>
                </button>
                <div class="export-menu" id="exportDropdownMenu">
                    <div class="export-menu-title">Ekspor Prestasi</div>
                    <a href="{{ route('admin.export', 'prestasi') }}">
                        <span>Semua Prestasi (Lengkap)</span>
                        <span class="tag">CSV</span>
                    </a>
                    <a href="{{ route('admin.export', 'prestasi-disetujui') }}">
                        <span>Prestasi Disetujui</span>
                        <span class="tag">CSV</span>
                    </a>
                    <a href="{{ route('admin.export', 'prestasi-menunggu') }}">
                        <span>Prestasi Menunggu Verifikasi</span>
                        <span class="tag">CSV</span>
                    </a>
                    <a href="{{ route('admin.export', 'prestasi-ditolak') }}">
                        <span>Prestasi Ditolak</span>
                        <span class="tag">CSV</span>
                    </a>
                    <div class="export-menu-divider"></div>
                    <div class="export-menu-title">Ekspor Sivitas & Rekap</div>
                    <a href="{{ route('admin.export', 'mahasiswa') }}">
                        <span>Data Mahasiswa Berprestasi</span>
                        <span class="tag">CSV</span>
                    </a>
                    <a href="{{ route('admin.export', 'dosen') }}">
                        <span>Data Dosen Berprestasi</span>
                        <span class="tag">CSV</span>
                    </a>
                    <a href="{{ route('admin.export', 'verifikasi') }}">
                        <span>Log Riwayat Verifikasi</span>
                        <span class="tag">CSV</span>
                    </a>
                    <a href="{{ route('admin.export', 'tren-tahunan') }}">
                        <span>Rekap Perkembangan Tahunan</span>
                        <span class="tag">CSV</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- RINGKASAN STATISTIK (DESAIN SERAGAM DENGAN DASHBOARD ADMIN) --}}
        <section class="stats">
            {{-- KARTU 1: TOTAL PRESTASI --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Total Data Prestasi</span>
                    <span class="stat-status-badge neutral">Semua Arsip</span>
                </div>
                <div class="stat-number">
                    {{ number_format($prestasis->count(), 0, ',', '.') }}
                </div>
                <div class="stat-note">Seluruh pengajuan tercatat di sistem</div>
            </article>

            {{-- KARTU 2: MENUNGGU VERIFIKASI --}}
            <article class="stat-card stat-card-action @if(($totalMenunggu ?? 0) > 0) has-pending @endif">
                <div class="stat-top-row">
                    <span class="stat-label">Menunggu Verifikasi</span>
                    @if(($totalMenunggu ?? 0) > 0)
                        <span class="stat-status-badge pending">Butuh Tindakan</span>
                    @endif
                </div>
                <div class="stat-number stat-number-pending">
                    {{ number_format($totalMenunggu, 0, ',', '.') }}
                </div>
                @if(($totalMenunggu ?? 0) > 0)
                    <a href="{{ route('admin.verifikasi.index') }}" class="stat-card-link">
                        Tinjau Antrean Verifikasi &rarr;
                    </a>
                @else
                    <div class="stat-note">Semua pengajuan telah diproses</div>
                @endif
            </article>

            {{-- KARTU 3: PRESTASI DISETUJUI --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Prestasi Disetujui</span>
                    @php
                        $rasioDisetujui = $prestasis->count() > 0
                            ? round((($totalDisetujui ?? 0) / $prestasis->count()) * 100)
                            : 0;
                    @endphp
                    <span class="stat-status-badge success">{{ $rasioDisetujui }}% Rasio</span>
                </div>
                <div class="stat-number stat-number-approved">
                    {{ number_format($totalDisetujui, 0, ',', '.') }}
                </div>
                <div class="stat-note">Pencapaian valid &amp; terpublikasi</div>
            </article>

            {{-- KARTU 4: PRESTASI DITOLAK --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Prestasi Ditolak</span>
                    <span class="stat-status-badge danger">Ditolak</span>
                </div>
                <div class="stat-number" style="color: #B91C1C;">
                    {{ number_format($totalDitolak, 0, ',', '.') }}
                </div>
                <div class="stat-note">Pengajuan tidak memenuhi syarat</div>
            </article>
        </section>

        {{-- PANEL DAFTAR PRESTASI (BENTUK LIST, BUKAN TABLE) --}}
        <section class="panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Daftar Prestasi Sivitas Akademika</h2>
                    <p class="panel-subtitle">Gunakan bilah pencarian nama peserta atau prestasi serta filter di bawah ini untuk menyaring data secara real-time.</p>
                </div>
                <div>
                    <span class="list-counter" id="listCounterBadge">
                        Menampilkan <strong id="visibleCount">{{ $prestasis->count() }}</strong> dari {{ $prestasis->count() }} data
                    </span>
                </div>
            </div>

            {{-- SEARCH BAR & FILTER --}}
            <div class="search-filter-box">
                <div class="search-main-row">
                    <div class="search-input-wrap">
                        <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input
                            type="search"
                            id="searchPrestasi"
                            class="search-input"
                            placeholder="Cari nama peserta, NIM/NIP, judul prestasi, penyelenggara, atau fakultas/prodi..."
                            autocomplete="off"
                        >
                    </div>
                </div>

                <div class="filters-grid">
                    <select id="filterStatus" class="filter-select">
                        <option value="">Semua Status Verifikasi</option>
                        <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>

                    <select id="filterTingkat" class="filter-select">
                        <option value="">Semua Tingkat Kompetisi</option>
                        @foreach ($tingkats as $tingkatItem)
                            <option value="{{ strtolower($tingkatItem->nama_tingkat) }}">
                                {{ $tingkatItem->nama_tingkat }}
                            </option>
                        @endforeach
                    </select>

                    <select id="filterKategori" class="filter-select">
                        <option value="">Semua Kategori</option>
                        @if (isset($kategoris))
                            @foreach ($kategoris as $kat)
                                <option value="{{ strtolower($kat->nama_kategori) }}">
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        @else
                            <option value="akademik">Akademik</option>
                            <option value="non akademik">Non Akademik</option>
                        @endif
                    </select>

                    <button type="button" id="btnResetFilter" class="filter-reset-btn">
                        Atur Ulang Filter
                    </button>
                </div>
            </div>

            {{-- TABEL DATA DAFTAR PRESTASI (MODERN, RAPI, BERSIH) --}}
            <div class="admin-table-wrapper" id="prestasiTableWrapper">
                <table class="admin-prestasi-table">
                    <thead>
                        <tr>
                            <th style="width: 38%;">Prestasi &amp; Capaian</th>
                            <th style="width: 28%;">Pengaju / Sivitas</th>
                            <th style="width: 18%;">Status Verifikasi</th>
                            <th style="width: 16%; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="prestasiTableBody">
                        @forelse ($prestasis as $prestasi)
                            @php
                                $tingkat = $prestasi->tingkat?->nama_tingkat ?? 'Belum ditentukan';
                                $kategori = $prestasi->kategori?->nama_kategori ?? 'Umum';
                                $status = $prestasi->status;

                                $pengaju = $prestasi->anggota->first(fn ($a) => $a->peran === 'pengaju')
                                    ?? $prestasi->anggota->first();

                                $namaPengaju = $pengaju?->nama ?? $pengaju?->sivitas?->nama ?? 'Nama Belum Terhubung';
                                $nimNipPengaju = $pengaju?->nim_nip ?? $pengaju?->sivitas?->user?->nim_nip ?? '—';
                                $roleSivitas = ucfirst($pengaju?->sivitas?->user?->role ?? $pengaju?->sivitas?->jenis_sivitas ?? 'Sivitas');
                                $fakultas = $pengaju?->sivitas?->fakultas;
                                $prodi = $pengaju?->sivitas?->program_studi;

                                $anggotaList = $prestasi->anggota->map(function ($a) {
                                    $nm = $a->nama ?? $a->sivitas?->nama ?? '';
                                    $id = $a->nim_nip ?? $a->sivitas?->user?->nim_nip ?? '';
                                    return $id ? "{$nm} ({$id})" : $nm;
                                })->filter()->implode(', ');

                                $statusLabel = match ($status) {
                                    'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                    'disetujui' => 'Disetujui',
                                    'ditolak' => 'Ditolak',
                                    'perlu_perbaikan' => 'Perlu Perbaikan',
                                    default => ucfirst($status),
                                };

                                $buktiData = $prestasi->bukti->map(function ($b) {
                                    return [
                                        'jenis' => $b->jenis_bukti,
                                        'nama' => $b->nama_file ?: 'Dokumen Bukti',
                                        'url' => \Illuminate\Support\Facades\Storage::disk('public')->url($b->file_path),
                                    ];
                                })->values();

                                $searchCorpus = strtolower(
                                    $prestasi->nama_prestasi . ' ' .
                                    $namaPengaju . ' ' .
                                    $nimNipPengaju . ' ' .
                                    $anggotaList . ' ' .
                                    ($prestasi->penyelenggara ?? '') . ' ' .
                                    ($prestasi->peringkat ?? '') . ' ' .
                                    ($prestasi->tahun ?? '') . ' ' .
                                    $tingkat . ' ' .
                                    $kategori . ' ' .
                                    ($fakultas ?? '') . ' ' .
                                    ($prodi ?? '') . ' ' .
                                    $roleSivitas
                                );

                                $payload = [
                                    'id' => $prestasi->id,
                                    'nama_prestasi' => $prestasi->nama_prestasi,
                                    'nama_pengaju' => $namaPengaju,
                                    'nim_nip' => $nimNipPengaju,
                                    'role_sivitas' => $roleSivitas,
                                    'prodi' => $prodi,
                                    'fakultas' => $fakultas,
                                    'anggota_list' => $anggotaList,
                                    'tingkat' => $tingkat,
                                    'kategori' => $kategori,
                                    'peringkat' => $prestasi->peringkat ?: '—',
                                    'penyelenggara' => $prestasi->penyelenggara ?: '—',
                                    'tahun' => $prestasi->tahun ?: '—',
                                    'jenis_prestasi' => ucfirst($prestasi->jenis_prestasi ?? 'Individu'),
                                    'deskripsi' => $prestasi->deskripsi,
                                    'status' => $status,
                                    'status_label' => $statusLabel,
                                    'tanggal_pengajuan' => $prestasi->created_at ? $prestasi->created_at->format('d M Y, H:i') : '—',
                                    'bukti' => $buktiData,
                                    'verifikasi_url' => route('admin.verifikasi.index'),
                                ];
                            @endphp

                            <tr
                                class="prestasi-row"
                                data-search="{{ $searchCorpus }}"
                                data-status="{{ $status }}"
                                data-tingkat="{{ strtolower($tingkat) }}"
                                data-kategori="{{ strtolower($kategori) }}"
                            >
                                {{-- KOLOM 1: PRESTASI & CAPAIAN --}}
                                <td>
                                    <div class="table-prestasi-title">{{ $prestasi->nama_prestasi }}</div>
                                    <div class="table-prestasi-meta">
                                        @if ($prestasi->peringkat)
                                            <span class="badge-capaian-tag">{{ $prestasi->peringkat }}</span>
                                            <span class="meta-separator">&bull;</span>
                                        @endif
                                        <span>{{ $tingkat }}</span>
                                        <span class="meta-separator">&bull;</span>
                                        <span>{{ $kategori }}</span>
                                        @if ($prestasi->penyelenggara)
                                            <span class="meta-separator">&bull;</span>
                                            <span>{{ $prestasi->penyelenggara }}</span>
                                        @endif
                                        @if ($prestasi->tahun)
                                            <span class="meta-separator">&bull;</span>
                                            <span>Tahun {{ $prestasi->tahun }}</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- KOLOM 2: PENGAJU / SIVITAS --}}
                                <td>
                                    <div class="table-user-cell">
                                        <div class="table-avatar" aria-hidden="true">
                                            {{ strtoupper(mb_substr($namaPengaju, 0, 1)) }}
                                        </div>
                                        <div class="table-user-info">
                                            <div class="table-user-name" title="{{ $namaPengaju }}">
                                                {{ $namaPengaju }}
                                                @if ($nimNipPengaju && $nimNipPengaju !== '—')
                                                    <span style="font-weight: 500; color: #8F81A3;">({{ $nimNipPengaju }})</span>
                                                @endif
                                            </div>
                                            <div class="table-user-sub">
                                                {{ $roleSivitas }}@if ($prodi) &middot; {{ $prodi }} @endif
                                                @if ($prestasi->anggota->count() > 1)
                                                    <span style="color: var(--purple); font-weight: 600;">(Tim)</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- KOLOM 3: STATUS VERIFIKASI (RATA KIRI & SERAGAM) --}}
                                <td>
                                    <span class="status-badge-modern status-{{ $status }}">
                                        <span class="status-dot"></span>
                                        <span>{{ $statusLabel }}</span>
                                    </span>
                                </td>

                                {{-- KOLOM 4: AKSI (RATA KANAN & UKURAN PERSIS SAMA 145px) --}}
                                <td style="text-align: right;">
                                    @if ($status === 'menunggu_verifikasi')
                                        <button
                                            type="button"
                                            class="btn-row-action highlight"
                                            data-prestasi='@json($payload)'
                                            onclick="openDetailPrestasiModal(this)"
                                            title="Tinjau dan verifikasi pengajuan ini"
                                        >
                                            Tinjau Prestasi &rarr;
                                        </button>
                                    @else
                                        <button
                                            type="button"
                                            class="btn-row-action"
                                            data-prestasi='@json($payload)'
                                            onclick="openDetailPrestasiModal(this)"
                                            title="Lihat rincian lengkap pengajuan ini"
                                        >
                                            Lihat Rincian
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 40px 20px; color: #8A7A9E;">
                                    Belum ada data prestasi yang tersimpan di sistem.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="prestasiEmptyState" class="empty-search-state" style="display: none; margin-top: 14px;">
                <h3>Pencarian Tidak Ditemukan</h3>
                <p>Tidak ada prestasi atau nama peserta yang cocok dengan kata kunci dan filter yang Anda pilih.</p>
                <button type="button" id="btnEmptyReset" class="filter-reset-btn" style="margin-top: 10px;">
                    Atur Ulang Filter
                </button>
            </div>
        </section>

        {{-- MODAL DETAIL PRESTASI (LUAS, LAPANG, BERSIH, TIDAK MEPET) --}}
        <div class="modal-overlay" id="modalDetailOverlay" aria-hidden="true">
            <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modalDetailFieldJudul">
                <header class="modal-header">
                    <div class="modal-header-main">
                        <div class="modal-eyebrow">RINCIAN DATA PRESTASI</div>
                        <h3 class="modal-header-title" id="modalDetailFieldJudul">—</h3>
                        <div class="modal-header-status" id="modalDetailFieldStatusBadge"></div>
                    </div>
                    <button type="button" class="modal-close-btn" onclick="closeDetailPrestasiModal()" aria-label="Tutup Rincian">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </header>

                <div class="modal-body">
                    {{-- SEKSI 1: PROFIL PENGAJU --}}
                    <div class="modal-profile-strip">
                        <div class="modal-profile-avatar" id="modalDetailFieldAvatar">S</div>
                        <div class="modal-profile-details">
                            <div class="modal-profile-name" id="modalDetailFieldPengajuNama">—</div>
                            <div class="modal-profile-meta" id="modalDetailFieldPengajuMeta">—</div>
                        </div>
                        <div class="modal-submission-date" id="modalDetailTanggalPengajuan"></div>
                    </div>

                    {{-- ANGGOTA TIM (JIKA TIM) --}}
                    <div class="modal-team-strip" id="modalDetailTeamWrapper" style="display: none;">
                        <strong style="color: #6E538E;">Anggota Tim Lainnya:</strong>
                        <span id="modalDetailFieldAnggota" style="margin-left: 6px;">—</span>
                    </div>

                    {{-- SEKSI 2: INFORMASI KOMPETISI & CAPAIAN --}}
                    <div class="modal-section-clean">
                        <div class="modal-clean-title">Informasi Capaian &amp; Kompetisi</div>
                        <div class="modal-clean-grid">
                            <div class="modal-grid-item">
                                <span class="modal-item-label">Capaian / Peringkat</span>
                                <span class="modal-item-val highlight-capaian" id="modalDetailFieldPeringkat">—</span>
                            </div>
                            <div class="modal-grid-item">
                                <span class="modal-item-label">Tingkat Kompetisi</span>
                                <span class="modal-item-val" id="modalDetailFieldTingkat">—</span>
                            </div>
                            <div class="modal-grid-item">
                                <span class="modal-item-label">Kategori Bidang</span>
                                <span class="modal-item-val" id="modalDetailFieldKategori">—</span>
                            </div>
                            <div class="modal-grid-item">
                                <span class="modal-item-label">Penyelenggara</span>
                                <span class="modal-item-val" id="modalDetailFieldPenyelenggara">—</span>
                            </div>
                            <div class="modal-grid-item">
                                <span class="modal-item-label">Tahun Perolehan</span>
                                <span class="modal-item-val" id="modalDetailFieldTahun">—</span>
                            </div>
                            <div class="modal-grid-item">
                                <span class="modal-item-label">Jenis Kepesertaan</span>
                                <span class="modal-item-val" id="modalDetailFieldJenis">—</span>
                            </div>
                        </div>
                    </div>

                    {{-- SEKSI 3: DESKRIPSI KEGIATAN --}}
                    <div class="modal-section-clean" id="modalDetailDescWrapper" style="display: none;">
                        <div class="modal-clean-title">Deskripsi Kegiatan</div>
                        <div class="modal-clean-desc" id="modalDetailFieldDeskripsi"></div>
                    </div>

                    {{-- SEKSI 4: BERKAS BUKTI PENDUKUNG --}}
                    <div class="modal-section-clean">
                        <div class="modal-clean-title">Dokumen &amp; Berkas Bukti</div>
                        <ul class="modal-evidence-list-spacious" id="modalDetailEvidenceList"></ul>
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn-modal-dismiss" onclick="closeDetailPrestasiModal()">
                        Tutup Rincian
                    </button>
                    <a href="#" id="modalDetailBtnVerifikasi" class="btn-modal-action" style="display: none;">
                        Buka Halaman Verifikasi &rarr;
                    </a>
                </footer>
            </div>
        </div>
    </main>
</div>

<script>
    // DROPDOWN EXPORT LOGIC
    const exportTrigger = document.getElementById('exportDropdownTrigger');
    const exportMenu = document.getElementById('exportDropdownMenu');

    if (exportTrigger && exportMenu) {
        exportTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            exportMenu.classList.toggle('show');
            exportTrigger.setAttribute('aria-expanded', exportMenu.classList.contains('show'));
        });

        document.addEventListener('click', (e) => {
            if (!exportMenu.contains(e.target) && e.target !== exportTrigger) {
                exportMenu.classList.remove('show');
                exportTrigger.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // SEARCH & FILTER LOGIC (CLIENT-SIDE INSTANT FILTER)
    const searchInput = document.getElementById('searchPrestasi');
    const statusSelect = document.getElementById('filterStatus');
    const tingkatSelect = document.getElementById('filterTingkat');
    const kategoriSelect = document.getElementById('filterKategori');
    const resetBtn = document.getElementById('btnResetFilter');
    const emptyResetBtn = document.getElementById('btnEmptyReset');

    const rows = [...document.querySelectorAll('#prestasiTableBody tr.prestasi-row')];
    const tableWrapper = document.getElementById('prestasiTableWrapper');
    const emptyState = document.getElementById('prestasiEmptyState');
    const visibleCounter = document.getElementById('visibleCount');

    function applyFilter() {
        const query = searchInput.value.trim().toLowerCase();
        const selectedStatus = statusSelect.value;
        const selectedTingkat = tingkatSelect.value;
        const selectedKategori = kategoriSelect.value;

        let matched = 0;

        rows.forEach((row) => {
            const rowSearch = row.dataset.search || '';
            const rowStatus = row.dataset.status || '';
            const rowTingkat = row.dataset.tingkat || '';
            const rowKategori = row.dataset.kategori || '';

            const matchQuery = !query || rowSearch.includes(query);
            const matchStatus = !selectedStatus || rowStatus === selectedStatus;
            const matchTingkat = !selectedTingkat || rowTingkat === selectedTingkat;
            const matchKategori = !selectedKategori || rowKategori === selectedKategori;

            const isVisible = matchQuery && matchStatus && matchTingkat && matchKategori;
            row.style.display = isVisible ? '' : 'none';

            if (isVisible) matched++;
        });

        if (visibleCounter) {
            visibleCounter.textContent = matched;
        }

        if (emptyState) {
            emptyState.style.display = (rows.length > 0 && matched === 0) ? 'block' : 'none';
        }
        if (tableWrapper) {
            tableWrapper.style.display = (rows.length > 0 && matched === 0) ? 'none' : 'block';
        }
    }

    function resetFilters() {
        searchInput.value = '';
        statusSelect.value = '';
        tingkatSelect.value = '';
        kategoriSelect.value = '';
        applyFilter();
        searchInput.focus();
    }

    searchInput.addEventListener('input', applyFilter);
    statusSelect.addEventListener('change', applyFilter);
    tingkatSelect.addEventListener('change', applyFilter);
    kategoriSelect.addEventListener('change', applyFilter);
    if (resetBtn) resetBtn.addEventListener('click', resetFilters);
    if (emptyResetBtn) emptyResetBtn.addEventListener('click', resetFilters);

    // MODAL DETAIL PRESTASI LOGIC (ADMIN - LEGA, RAPI, TIDAK MEPET)
    const modalDetailOverlay = document.getElementById('modalDetailOverlay');

    function openDetailPrestasiModal(btn) {
        const raw = btn.getAttribute('data-prestasi');
        if (!raw) return;

        try {
            const data = JSON.parse(raw);

            // Judul Prestasi
            document.getElementById('modalDetailFieldJudul').textContent = data.nama_prestasi || '—';

            // Status Badge
            const statusBadgeContainer = document.getElementById('modalDetailFieldStatusBadge');
            statusBadgeContainer.innerHTML = `
                <span class="status-badge-modern status-${data.status || 'menunggu_verifikasi'}">
                    <span class="status-dot"></span>
                    <span>${escapeHtml(data.status_label)}</span>
                </span>
            `;

            // Field Kompetisi
            document.getElementById('modalDetailFieldTingkat').textContent = data.tingkat || '—';
            document.getElementById('modalDetailFieldKategori').textContent = data.kategori || '—';
            document.getElementById('modalDetailFieldPeringkat').textContent = data.peringkat || '—';
            document.getElementById('modalDetailFieldPenyelenggara').textContent = data.penyelenggara || '—';
            document.getElementById('modalDetailFieldTahun').textContent = data.tahun || '—';
            document.getElementById('modalDetailFieldJenis').textContent = data.jenis_prestasi || '—';

            // Profil Pengaju Utama
            const firstLetter = (data.nama_pengaju && data.nama_pengaju.trim() !== '')
                ? data.nama_pengaju.trim().charAt(0).toUpperCase()
                : 'S';
            document.getElementById('modalDetailFieldAvatar').textContent = firstLetter;

            const pengajuNamaFormatted = `${escapeHtml(data.nama_pengaju || 'Nama Pengaju')}` +
                (data.nim_nip && data.nim_nip !== '—' ? ` <span style="font-weight: 500; color: #7B6D8F;">(${escapeHtml(data.nim_nip)})</span>` : '');
            document.getElementById('modalDetailFieldPengajuNama').innerHTML = pengajuNamaFormatted;

            const metaParts = [];
            if (data.role_sivitas) metaParts.push(escapeHtml(data.role_sivitas));
            if (data.prodi) metaParts.push(escapeHtml(data.prodi));
            if (data.fakultas) metaParts.push(escapeHtml(data.fakultas));
            document.getElementById('modalDetailFieldPengajuMeta').textContent = metaParts.length > 0 ? metaParts.join(' · ') : 'Sivitas Akademika';

            // Anggota Tim
            const teamWrapper = document.getElementById('modalDetailTeamWrapper');
            const anggotaField = document.getElementById('modalDetailFieldAnggota');
            if (data.anggota_list && data.anggota_list.trim() !== '') {
                anggotaField.textContent = data.anggota_list;
                teamWrapper.style.display = 'block';
            } else {
                anggotaField.textContent = 'Individu (Tanpa Anggota Tambahan)';
                teamWrapper.style.display = 'block';
            }

            // Tanggal Pengajuan
            const tglEl = document.getElementById('modalDetailTanggalPengajuan');
            if (tglEl) {
                tglEl.textContent = data.tanggal_pengajuan ? `Diajukan pada: ${data.tanggal_pengajuan}` : '';
            }

            // Deskripsi
            const descWrapper = document.getElementById('modalDetailDescWrapper');
            const descBox = document.getElementById('modalDetailFieldDeskripsi');
            if (data.deskripsi && data.deskripsi.trim() !== '') {
                descBox.textContent = data.deskripsi;
                descWrapper.style.display = 'block';
            } else {
                descWrapper.style.display = 'none';
            }

            // Evidence list
            const evidenceList = document.getElementById('modalDetailEvidenceList');
            evidenceList.innerHTML = '';
            if (data.bukti && data.bukti.length > 0) {
                data.bukti.forEach(b => {
                    const li = document.createElement('li');
                    li.className = 'modal-evidence-item-spacious';
                    li.innerHTML = `
                        <div class="evidence-item-left">
                            <div class="evidence-file-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                            <div>
                                <div class="evidence-file-title">${escapeHtml(b.nama)}</div>
                                <div class="evidence-file-kind">Jenis Berkas: ${escapeHtml(b.jenis)}</div>
                            </div>
                        </div>
                        <a href="${b.url}" target="_blank" rel="noopener noreferrer" class="btn-open-doc">
                            <span>Lihat Berkas</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    `;
                    evidenceList.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.style.color = '#8C7E9E';
                li.style.fontSize = '13px';
                li.style.padding = '12px 14px';
                li.style.background = '#FAF8FE';
                li.style.borderRadius = '8px';
                li.textContent = 'Tidak ada dokumen bukti yang terlampir pada pengajuan ini.';
                evidenceList.appendChild(li);
            }

            // Quick verifikasi button
            const btnVerif = document.getElementById('modalDetailBtnVerifikasi');
            if (data.status === 'menunggu_verifikasi' && data.verifikasi_url) {
                btnVerif.href = data.verifikasi_url;
                btnVerif.style.display = 'inline-flex';
            } else {
                btnVerif.style.display = 'none';
            }

            modalDetailOverlay.classList.add('active');
            modalDetailOverlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        } catch (err) {
            console.error('Gagal membuka rincian prestasi:', err);
        }
    }

    function closeDetailPrestasiModal() {
        if (modalDetailOverlay) {
            modalDetailOverlay.classList.remove('active');
            modalDetailOverlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
    }

    if (modalDetailOverlay) {
        modalDetailOverlay.addEventListener('click', (e) => {
            if (e.target === modalDetailOverlay) {
                closeDetailPrestasiModal();
            }
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeDetailPrestasiModal();
        }
    });

    function escapeHtml(str) {
        if (!str) return '';
        return str
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
</script>
</body>
</html>
