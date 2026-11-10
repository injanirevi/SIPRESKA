<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun Pengguna (Super Admin) | SIPRESKA</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .sidebar, .sidebar * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        :root {
            --purple: #5B3A8E;
            --purple-dark: #432765;
            --lavender: #EEE6F8;
            --gold: #C9A227;
            --text: #342847;
            --muted: #80758F;
            --border: #E7DFF0;
            --card-bg: #FFFFFF;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(circle at 90% 5%, rgba(197,165,233,.22), transparent 30%),
                linear-gradient(135deg, #FFFFFF, #F8F5FC 48%, #EEE5F8);
        }

        .layout { min-height: 100vh; }

        /* SIDEBAR ADMIN / SUPER ADMIN */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 250px;
            height: 100vh;
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            background: rgba(255,255,255,.98);
            border-right: 1px solid var(--border);
            box-shadow: 5px 0 25px rgba(67,39,101,.035);
            z-index: 100;
            overflow-y: auto;
        }

        .logo {
            padding: 0 10px;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: 1px;
            background: linear-gradient(90deg,#8058B8,#5B3A8E,#432765);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .logo small {
            display: block;
            max-width: 190px;
            margin-top: 7px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 400;
            line-height: 1.6;
        }

        .gold-line {
            width: 42px;
            height: 3px;
            flex-shrink: 0;
            margin: 16px 10px 30px;
            border-radius: 5px;
            background: var(--gold);
        }

        .menu-title {
            margin: 0 10px 13px;
            color: #A198AE;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.3px;
        }

        .menu { display: flex; flex-direction: column; gap: 8px; }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border: 1px solid transparent;
            border-radius: 10px;
            color: #655B73;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.5;
            transition: all .2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu a:hover {
            background: #FAF7FD;
            color: var(--purple);
            transform: translateX(3px);
        }

        .menu a.active {
            background: linear-gradient(135deg, #F3ECF9 0%, #EDE1F7 100%);
            border-color: #E2D1F3;
            color: var(--purple);
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(91, 58, 142, 0.08);
        }

        .menu-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            color: inherit;
        }

        .menu a.active .menu-icon {
            color: var(--purple);
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
            padding-top: 24px;
        }

        .logout button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #F5D3D3;
            border-radius: 10px;
            background: #FFF5F5;
            color: #B91C1C;
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s ease;
        }

        .logout button:hover {
            background: #FEE2E2;
            border-color: #F87171;
            transform: translateY(-1px);
        }

        /* MAIN CONTENT AREA */
        .content {
            width: calc(100% - 250px);
            margin-left: 250px;
            padding: 36px 40px;
            min-width: 0;
        }

        /* TOP-BAR HEADER */
        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .top-header-left h1 {
            margin: 4px 0 0;
            font-size: 26px;
            font-weight: 800;
            color: var(--purple-dark);
            font-family: 'Poppins', sans-serif;
            letter-spacing: -0.4px;
        }

        .eyebrow {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: #8C6FA8;
            text-transform: uppercase;
        }

        .user-profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            border-radius: 30px;
            border: 1px solid var(--border);
            background: #FFFFFF;
            box-shadow: 0 2px 10px rgba(67,39,101,.04);
            font-size: 12.5px;
            font-weight: 700;
            color: var(--purple-dark);
        }

        .role-tag-super {
            padding: 2px 8px;
            border-radius: 6px;
            background: #F4EFFB;
            border: 1px solid #E3D4F5;
            color: var(--purple);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        /* WELCOME BANNER */
        .welcome {
            margin-bottom: 26px;
            padding: 24px 28px;
            border: 1px solid #E3D5F2;
            border-left: 5px solid var(--gold);
            border-radius: 16px;
            background: linear-gradient(115deg, #FFFFFF, #F6F0FC 52%, #E7D9F5);
            box-shadow: 0 8px 25px rgba(91,58,142,.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 18px;
        }

        .welcome-content {
            max-width: 680px;
        }

        .welcome h2 {
            margin: 0 0 8px;
            color: var(--purple-dark);
            font-size: 20px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }

        .welcome p {
            margin: 0;
            color: #746886;
            font-size: 13px;
            line-height: 1.7;
        }

        .btn-add-user {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 22px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #7A53B3 0%, #5B3A8E 100%);
            color: #FFFFFF;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(91,58,142,.22);
            transition: transform .15s ease, box-shadow .15s ease;
            white-space: nowrap;
        }

        .btn-add-user:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(91,58,142,.32);
            background: linear-gradient(135deg, #6C44A7 0%, #482A75 100%);
        }

        /* ALERT NOTICES */
        .notice {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 22px;
            font-size: 13px;
            font-weight: 600;
        }

        .notice.success {
            background: #EEFBF4;
            border: 1px solid #C3EEDB;
            color: #0E6B3B;
        }

        .notice.error {
            background: #FDF2F2;
            border: 1px solid #FACDCD;
            color: #B91C1C;
        }

        .notice-content {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .notice-close-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            color: inherit;
            opacity: 0.7;
            font-size: 16px;
            display: flex;
            align-items: center;
        }

        .notice-close-btn:hover {
            opacity: 1;
        }

        /* 5 STAT CARDS (SERAGAM DENGAN DASHBOARD ADMIN) */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 26px;
        }

        @media (max-width: 1250px) {
            .stats-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }

        @media (max-width: 850px) {
            .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: 1fr; }
        }

        .stat-card {
            min-width: 0;
            padding: 18px 20px;
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

        .stat-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            margin-bottom: 12px;
        }

        .stat-label {
            color: #6C5E7F;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: -0.1px;
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            padding: 2.5px 7px;
            border-radius: 6px;
            font-size: 10.5px;
            font-weight: 700;
            line-height: 1.2;
            white-space: nowrap;
        }

        .stat-pill.purple { background: #F4EFFB; color: #5B3A8E; border: 1px solid #E5D6F6; }
        .stat-pill.gold { background: #FFF7E6; color: #9A6C05; border: 1px solid #FFE6A8; }
        .stat-pill.blue { background: #EFF6FF; color: #1D4ED8; border: 1px solid #DBEAFE; }
        .stat-pill.amber { background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; }
        .stat-pill.green { background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; }

        .stat-number {
            color: #2D1A47;
            font-size: 28px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
            overflow-wrap: anywhere;
        }

        .stat-note {
            color: #8C7F9E;
            font-size: 11.5px;
            font-weight: 500;
            line-height: 1.4;
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
            color: var(--purple-dark);
            font-size: 18px;
            font-weight: 800;
            font-family: 'Poppins', sans-serif;
        }

        .panel-subtitle {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .list-counter {
            padding: 6px 12px;
            border-radius: 20px;
            background: #F4EFFA;
            color: var(--purple);
            font-size: 12px;
            font-weight: 700;
        }

        /* FILTER BAR */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 16px;
            border-radius: 12px;
            background: #FAF8FD;
            border: 1px solid #EDE6F5;
        }

        .search-input-wrap {
            position: relative;
            flex: 1;
            min-width: 260px;
        }

        .search-input-wrap svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9A8EB0;
            pointer-events: none;
        }

        .filter-input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1px solid #D8CBE6;
            border-radius: 9px;
            background: #FFFFFF;
            font-size: 13px;
            color: var(--text);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .filter-input:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(91,58,142,.12);
        }

        .filter-select {
            padding: 10px 14px;
            border: 1px solid #D8CBE6;
            border-radius: 9px;
            background: #FFFFFF;
            font-size: 13px;
            color: var(--text);
            outline: none;
            cursor: pointer;
            transition: border-color .15s;
            min-width: 170px;
        }

        .filter-select:focus {
            border-color: var(--purple);
        }

        .btn-filter {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            border: 1px solid transparent;
            border-radius: 9px;
            background: linear-gradient(135deg, #7A53B3, #5B3A8E);
            color: #FFFFFF;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
        }

        .btn-filter:hover {
            background: linear-gradient(135deg, #6C44A7, #482A75);
        }

        .btn-reset {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 14px;
            border: 1px solid #D8CBE6;
            border-radius: 9px;
            background: #FFFFFF;
            color: #6C5E7F;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background .15s, color .15s;
        }

        .btn-reset:hover {
            background: #F4EFFB;
            color: var(--purple);
        }

        /* TABLE */
        .table-wrap {
            overflow-x: auto;
            border: 1px solid #ECE3F5;
            border-radius: 13px;
            background: #FFFFFF;
            box-shadow: 0 3px 12px rgba(67, 39, 101, 0.035);
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        .users-table thead {
            background: #FAF8FD;
            border-bottom: 1px solid #ECE3F5;
        }

        .users-table th {
            padding: 13px 18px;
            font-size: 11px;
            font-weight: 700;
            color: #6C5B82;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            white-space: nowrap;
        }

        .users-table tbody tr {
            border-bottom: 1px solid #F3EDF8;
            transition: background 0.15s ease;
        }

        .users-table tbody tr:last-child {
            border-bottom: none;
        }

        .users-table tbody tr:hover {
            background: #FCFAFF;
        }

        .users-table td {
            padding: 14px 18px;
            vertical-align: middle;
        }

        .user-identity {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #F3ECFB, #E5D5F6);
            color: var(--purple);
            font-weight: 800;
            font-size: 12.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1.5px solid #E1D2F4;
        }

        .user-name-box strong {
            display: block;
            font-size: 13.5px;
            font-weight: 700;
            color: #2D1A47;
            line-height: 1.35;
        }

        .user-name-box span {
            font-size: 11.5px;
            color: #8C7E9E;
            font-weight: 500;
        }

        /* ROLE BADGES (CLEAN & MODERN, NO EMOJIS) */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.2px;
            white-space: nowrap;
        }

        .role-badge.super_admin {
            background: #F4EFFB;
            border: 1px solid #E4D5F6;
            color: #5B3A8E;
        }

        .role-badge.admin {
            background: #EFF6FF;
            border: 1px solid #DBEAFE;
            color: #1D4ED8;
        }

        .role-badge.dosen {
            background: #FEF3C7;
            border: 1px solid #FDE68A;
            color: #B45309;
        }

        .role-badge.mahasiswa {
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #047857;
        }

        .role-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        /* STATUS BADGE */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
        }

        .status-pill.aktif {
            background: #EDF9F1;
            color: #157A3C;
            border: 1px solid #C4ECCF;
        }

        .status-pill.aktif .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10B981;
        }

        .status-pill.nonaktif {
            background: #F4F1F7;
            color: #7A6F89;
            border: 1px solid #E2D9EC;
        }

        .status-pill.nonaktif .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #9CA3AF;
        }

        /* ACTION BUTTONS (RAPI, SEJAJAR & KONSISTEN) */
        .th-actions {
            text-align: right !important;
            width: 220px;
        }

        .td-actions {
            text-align: right;
            width: 220px;
            padding: 12px 18px !important;
        }

        .actions-cell {
            display: inline-flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }

        .btn-action-clean {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            height: 32px;
            padding: 0 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
            white-space: nowrap;
            background: #FAF7FD;
            border: 1px solid #DFD2ED;
            color: var(--purple);
        }

        .btn-action-clean:hover {
            background: #EDE4F8;
            border-color: var(--purple);
            color: var(--purple-dark);
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(91, 58, 142, 0.12);
        }

        .btn-action-delete {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.15s ease;
            background: #FFF5F5;
            border: 1px solid #FCD4D4;
            color: #DC2626;
        }

        .btn-action-delete:hover {
            background: #FEE2E2;
            border-color: #F87171;
            color: #B91C1C;
            transform: translateY(-1px);
        }

        .action-spacer {
            display: inline-block;
            width: 32px;
            height: 32px;
        }

        .pagination-wrap {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        /* MODALS (LAPANG, MODERN, NO EMOJIS) */
        .modal-backdrop {
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

        .modal-backdrop.show {
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
            max-width: 620px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid #ECE2F5;
        }

        .modal-header {
            padding: 22px 28px 18px;
            border-bottom: 1px solid #ECE4F4;
            background: #FAF8FD;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 17px;
            color: #2D1A47;
            font-weight: 800;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-close-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid #E2D7EE;
            background: #FFFFFF;
            color: #7A6991;
            cursor: pointer;
            transition: all .15s ease;
        }

        .modal-close-btn:hover {
            background: #F4EEFB;
            color: var(--purple);
            border-color: #CDBCE2;
        }

        .modal-body {
            padding: 24px 28px;
            overflow-y: auto;
            max-height: calc(90vh - 150px);
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 12.5px;
            font-weight: 700;
            color: #4A3A63;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #D8CBE6;
            border-radius: 9px;
            background: #FFFFFF;
            font-size: 13px;
            color: var(--text);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .form-control:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(91,58,142,.12);
        }

        .modal-footer {
            padding: 16px 28px;
            border-top: 1px solid #ECE4F4;
            background: #FAF8FD;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-modal-cancel {
            padding: 9px 18px;
            border-radius: 8px;
            border: 1px solid #D5C8E4;
            background: #FFFFFF;
            color: #5B3A8E;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-modal-cancel:hover {
            background: #F4EEFB;
            border-color: #5B3A8E;
        }

        .btn-modal-submit {
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
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(91, 58, 142, 0.25);
            transition: all .15s;
        }

        .btn-modal-submit:hover {
            background: linear-gradient(135deg, #6B43A6, #4A2B78);
            transform: translateY(-1px);
        }

        /* RESPONSIVE */
        @media (max-width: 950px) {
            .content {
                width: calc(100% - 210px);
                margin-left: 210px;
                padding: 24px 20px;
            }
            .sidebar { width: 210px; }
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
        }
    </style>
</head>

<body>
<div class="layout">

    {{-- SIDEBAR KONSISTEN (URUTAN IDENTIK DENGAN DASHBOARD ADMIN) --}}
    <aside class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SIPRESKA" width="34" height="36" style="display: block; margin-bottom: 8px; object-fit: contain;">
            SIPRESKA
            <small>Sistem Informasi Pendataan dan Pengelolaan Prestasi Sivitas</small>
        </div>

        <div class="gold-line"></div>
        <div class="menu-title">MENU SUPER ADMIN</div>

        <nav class="menu">
            {{-- 1. DASHBOARD --}}
            <a href="{{ route('dashboard') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </span>
                Dashboard
            </a>

            {{-- 2. DAFTAR PRESTASI --}}
            <a href="{{ route('admin.prestasi.index') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </span>
                Daftar Prestasi
            </a>

            {{-- 3. VERIFIKASI PRESTASI --}}
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

            {{-- 4. MANAJEMEN AKUN (POSISI KONSISTEN NOMOR 4) --}}
            <a href="{{ route('superadmin.users.index') }}" class="active">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </span>
                Manajemen Akun
            </a>

            {{-- 5. PANDUAN PENGGUNAAN --}}
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
                <button type="submit">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    <span>Keluar dari Akun</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="content">

        {{-- TOP HEADER BAR --}}
        <header class="top-header">
            <div class="top-header-left">
                <div class="eyebrow">PENGELOLAAN HAK AKSES SISTEM</div>
                <h1>Manajemen Akun Pengguna</h1>
            </div>
            <div class="user-profile-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--purple); flex-shrink: 0;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span>Super Administrator</span>
            </div>
        </header>

        {{-- WELCOME & TAMBAH PENGGUNA BARU --}}
        <section class="welcome">
            <div class="welcome-content">
                <h2>Pusat Kendali Pengguna & Hak Akses</h2>
                <p>
                    Sebagai Super Administrator, Anda memiliki kewenangan tertinggi untuk mengelola akun Administrator, Dosen, dan Mahasiswa, mengatur hak akses sistem, serta mereset kata sandi.
                </p>
            </div>

            <button type="button" class="btn-add-user" onclick="openCreateModal()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Tambah Akun Baru</span>
            </button>
        </section>

        {{-- ALERT MESSAGES (CLEAN SVG ICONS, NO EMOJIS) --}}
        @if (session('success'))
            <div class="notice success">
                <div class="notice-content">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="notice-close-btn" onclick="this.parentElement.remove()" aria-label="Tutup">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="notice error">
                <div class="notice-content">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" class="notice-close-btn" onclick="this.parentElement.remove()" aria-label="Tutup">&times;</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="notice error">
                <div class="notice-content" style="align-items: flex-start;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; margin-top:2px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <div>
                        <strong>Perhatian:</strong>
                        <ul style="margin: 4px 0 0; padding-left: 18px; font-weight: normal;">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="notice-close-btn" onclick="this.parentElement.remove()" aria-label="Tutup">&times;</button>
            </div>
        @endif

        {{-- 5 KARTU STATISTIK MODERN --}}
        <section class="stats-grid">
            {{-- KARTU 1: TOTAL SEMUA AKUN --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Total Semua Akun</span>
                    <span class="stat-pill purple">Semua Pengguna</span>
                </div>
                <div class="stat-number">{{ number_format($totalSemua, 0, ',', '.') }}</div>
                <div class="stat-note">Total akun terdaftar di sistem</div>
            </article>

            {{-- KARTU 2: SUPER ADMIN --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Super Admin</span>
                    <span class="stat-pill gold">Akses Penuh</span>
                </div>
                <div class="stat-number">{{ number_format($totalSuperAdmin, 0, ',', '.') }}</div>
                <div class="stat-note">Otoritas tingkat tertinggi</div>
            </article>

            {{-- KARTU 3: ADMINISTRATOR --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Administrator</span>
                    <span class="stat-pill blue">Verifikator</span>
                </div>
                <div class="stat-number">{{ number_format($totalAdmin, 0, ',', '.') }}</div>
                <div class="stat-note">Pengelola data & verifikasi</div>
            </article>

            {{-- KARTU 4: DOSEN --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Akun Dosen</span>
                    <span class="stat-pill amber">Sivitas Dosen</span>
                </div>
                <div class="stat-number">{{ number_format($totalDosen, 0, ',', '.') }}</div>
                <div class="stat-note">Sivitas dosen pengaju prestasi</div>
            </article>

            {{-- KARTU 5: MAHASISWA --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Akun Mahasiswa</span>
                    <span class="stat-pill green">Sivitas Mahasiswa</span>
                </div>
                <div class="stat-number">{{ number_format($totalMahasiswa, 0, ',', '.') }}</div>
                <div class="stat-note">Sivitas mahasiswa pengaju prestasi</div>
            </article>
        </section>

        {{-- PANEL DAFTAR PENGGUNA --}}
        <section class="panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Daftar Akun Pengguna Sistem</h2>
                    <p class="panel-subtitle">Gunakan fitur pencarian nama atau filter peran untuk menyaring akun secara instan.</p>
                </div>
                <span class="list-counter">Total {{ number_format($users->total(), 0, ',', '.') }} Akun</span>
            </div>

            {{-- SEARCH & FILTER FORM (NO EMOJIS) --}}
            <form action="{{ route('superadmin.users.index') }}" method="GET" class="filter-bar">
                <div class="search-input-wrap">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input
                        type="search"
                        name="q"
                        class="filter-input"
                        placeholder="Cari nama, NIM/NIP, email pengguna..."
                        value="{{ $q }}"
                    >
                </div>

                <select name="role" class="filter-select">
                    <option value="">Semua Peran (Role)</option>
                    <option value="super_admin" @selected($roleFilter === 'super_admin')>Super Administrator</option>
                    <option value="admin" @selected($roleFilter === 'admin')>Administrator</option>
                    <option value="dosen" @selected($roleFilter === 'dosen')>Dosen</option>
                    <option value="mahasiswa" @selected($roleFilter === 'mahasiswa')>Mahasiswa</option>
                </select>

                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="aktif" @selected($statusFilter === 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected($statusFilter === 'nonaktif')>Nonaktif</option>
                </select>

                <button type="submit" class="btn-filter">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <span>Cari</span>
                </button>

                @if ($q || $roleFilter || $statusFilter)
                    <a href="{{ route('superadmin.users.index') }}" class="btn-reset">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>
                        <span>Reset</span>
                    </a>
                @endif
            </form>

            {{-- TABEL PENGGUNA --}}
            <div class="table-wrap">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Pengguna / Identitas</th>
                            <th>Peran (Role)</th>
                            <th>Kontak & Email</th>
                            <th>Fakultas / Prodi / Jabatan</th>
                            <th>Status</th>
                            <th class="th-actions">Aksi Super Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $u)
                            @php
                                $nama = $u->admin?->nama ?? $u->sivitas?->nama ?? 'Tanpa Nama';
                                $email = $u->admin?->email ?? $u->sivitas?->email ?? '—';
                                $noHp = $u->admin?->no_hp ?? $u->sivitas?->no_hp ?? '—';
                                $jabatan = $u->admin?->jabatan ?? '—';
                                $prodi = $u->sivitas?->program_studi ?? $jabatan;
                                $fakultas = $u->sivitas?->fakultas ?? '—';
                                $status = $u->sivitas?->status ?? 'aktif';
                                $inisial = strtoupper(substr($nama, 0, 2));

                                $roleLabel = match($u->role) {
                                    'super_admin' => 'Super Admin',
                                    'admin' => 'Administrator',
                                    'dosen' => 'Dosen',
                                    'mahasiswa' => 'Mahasiswa',
                                    default => ucfirst($u->role),
                                };
                            @endphp
                            <tr>
                                <td>
                                    <div class="user-identity">
                                        <div class="user-avatar">{{ $inisial }}</div>
                                        <div class="user-name-box">
                                            <strong>{{ $nama }}</strong>
                                            <span>NIM/NIP: {{ $u->nim_nip ?: '—' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="role-badge {{ $u->role }}">
                                        <span class="role-dot"></span>
                                        {{ $roleLabel }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color:#30283D;">{{ $email }}</div>
                                    @if ($noHp !== '—')
                                        <small style="color: var(--muted);">{{ $noHp }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600; color:#30283D;">{{ $prodi }}</div>
                                    @if ($fakultas !== '—' && $fakultas !== 'Belum diisi')
                                        <small style="color: var(--muted);">{{ $fakultas }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-pill {{ $status }}">
                                        <span class="status-dot"></span>
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="td-actions">
                                    <div class="actions-cell">
                                        {{-- TOMBOL UBAH PASSWORD --}}
                                        <button
                                            type="button"
                                            class="btn-action-clean"
                                            title="Ubah Kata Sandi"
                                            onclick='openPasswordModal(@json($u->id), @json($nama), @json($u->nim_nip))'
                                        >
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="7.5" cy="15.5" r="5.5"></circle><path d="m21 2-9.6 9.6"></path><path d="m15.5 7.5 3 3L22 7l-3-3"></path></svg>
                                            <span>Kata Sandi</span>
                                        </button>

                                        {{-- TOMBOL EDIT AKUN --}}
                                        <button
                                            type="button"
                                            class="btn-action-clean"
                                            title="Edit Data Pengguna"
                                            onclick='openEditModal(@json($u->id), @json($nama), @json($u->nim_nip), @json($email), @json($u->role), @json($status), @json($u->admin?->jabatan), @json($u->sivitas?->program_studi), @json($u->sivitas?->fakultas), @json($noHp))'
                                        >
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path><path d="m15 5 4 4"></path></svg>
                                            <span>Edit</span>
                                        </button>

                                        {{-- TOMBOL HAPUS AKUN ATAU SPACER KONSISTEN --}}
                                        @if ($u->id !== auth()->id())
                                            <button type="button" class="btn-action-delete" title="Hapus Akun" aria-label="Hapus Akun" onclick="confirmDeleteUser('{{ route('superadmin.users.destroy', $u) }}', '{{ addslashes($nama) }}')">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                                            </button>
                                        @else
                                            <span class="action-spacer" title="Akun Anda Saat Ini"></span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px 20px; color: var(--muted);">
                                    Tidak ada data akun pengguna yang cocok dengan kriteria pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $users->links() }}
            </div>
        </section>

    </main>
</div>

{{-- MODAL TAMBAH AKUN BARU (LAPANG & MODERN, NO EMOJIS) --}}
<div class="modal-backdrop" id="modalCreate">
    <div class="modal-card">
        <div class="modal-header">
            <h3>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--purple);"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Akun Pengguna Baru
            </h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('modalCreate')" aria-label="Tutup">&times;</button>
        </div>
        <form action="{{ route('superadmin.users.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Ahmad Fauzi, M.Kom" required>
                </div>
                <div class="form-group">
                    <label>Peran (Role) *</label>
                    <select name="role" class="form-control" id="createRoleSelect" onchange="toggleRoleFields('create')" required>
                        <option value="admin">Administrator</option>
                        <option value="super_admin">Super Administrator</option>
                        <option value="dosen">Dosen</option>
                        <option value="mahasiswa">Mahasiswa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>NIM / NIP / Username Login *</label>
                    <input type="text" name="nim_nip" class="form-control" placeholder="Nomor identitas atau username" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" placeholder="email@uinssc.ac.id" required>
                </div>
                <div class="form-group">
                    <label>Kata Sandi Awal * (Min. 6 Karakter)</label>
                    <input type="password" name="password" class="form-control" placeholder="Tentukan kata sandi awal" required minlength="6">
                </div>
                <div id="createAdminFields">
                    <div class="form-group">
                        <label>Jabatan / Unit</label>
                        <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Staf Kemahasiswaan">
                    </div>
                </div>
                <div id="createSivitasFields" style="display:none;">
                    <div class="form-group">
                        <label>Fakultas</label>
                        <input type="text" name="fakultas" class="form-control" placeholder="Contoh: Ilmu Tarbiyah dan Keguruan">
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <input type="text" name="program_studi" class="form-control" placeholder="Contoh: Informatika">
                    </div>
                </div>
                <div class="form-group">
                    <label>Nomor Handphone (Opsional)</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('modalCreate')">Batal</button>
                <button type="submit" class="btn-modal-submit">Simpan Akun Baru</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL UBAH KATA SANDI (SUPER ADMIN) --}}
<div class="modal-backdrop" id="modalPassword">
    <div class="modal-card">
        <div class="modal-header">
            <h3>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--purple);"><circle cx="7.5" cy="15.5" r="5.5"></circle><path d="m21 2-9.6 9.6"></path><path d="m15.5 7.5 3 3L22 7l-3-3"></path></svg>
                Ubah Kata Sandi Akun
            </h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('modalPassword')" aria-label="Tutup">&times;</button>
        </div>
        <form id="formUpdatePassword" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <p style="font-size: 13px; color: var(--muted); margin-top: 0; margin-bottom: 18px; line-height: 1.6;">
                    Anda mengubah kata sandi untuk akun <strong id="pwModalUserName" style="color:var(--purple-dark);"></strong> (<span id="pwModalUserNip"></span>).
                </p>
                <div class="form-group">
                    <label>Kata Sandi Baru * (Min. 6 Karakter)</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi baru" required minlength="6">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Kata Sandi Baru *</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru" required minlength="6">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('modalPassword')">Batal</button>
                <button type="submit" class="btn-modal-submit">Perbarui Kata Sandi</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT DATA AKUN --}}
{{-- MODAL HAPUS USER (MODERN SIPRESKA) --}}
<div class="modal-backdrop" id="modalDelete" role="dialog" aria-modal="true" aria-labelledby="modalDeleteTitle">
    <div class="modal-card" style="max-width: 440px; text-align: center; padding: 28px 24px;">
        <div style="width: 58px; height: 58px; border-radius: 50%; background: #FEF2F2; color: #EF4444; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 0 6px #FFF1F2;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </div>
        <h3 id="modalDeleteTitle" style="font-size: 19px; font-weight: 800; color: #2D1B4E; margin: 0 0 8px;">Hapus Akun Pengguna?</h3>
        <p style="font-size: 13.5px; color: #64748B; line-height: 1.5; margin: 0 0 20px;">
            Akun <strong id="deleteTargetUserName" style="color: #1E293B;">—</strong> akan dihapus permanen dari sistem. Tindakan ini tidak dapat dibatalkan.
        </p>
        <form id="formDeleteUser" method="POST" action="">
            @csrf
            @method('DELETE')
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modalDelete')" style="flex: 1; padding: 11px 18px; border-radius: 10px; font-weight: 700;">Batal</button>
                <button type="submit" class="btn" style="flex: 1.2; padding: 11px 18px; border-radius: 10px; font-weight: 700; background: linear-gradient(135deg, #EF4444, #DC2626); color: #fff; border: none; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35); cursor: pointer;">Ya, Hapus Akun</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-backdrop" id="modalEdit">
    <div class="modal-card">
        <div class="modal-header">
            <h3>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--purple);"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path><path d="m15 5 4 4"></path></svg>
                Edit Data Akun Pengguna
            </h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('modalEdit')" aria-label="Tutup">&times;</button>
        </div>
        <form id="formEditUser" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" id="editNama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Peran (Role) *</label>
                    <select name="role" id="editRole" class="form-control" onchange="toggleRoleFields('edit')" required>
                        <option value="super_admin">Super Administrator</option>
                        <option value="admin">Administrator</option>
                        <option value="dosen">Dosen</option>
                        <option value="mahasiswa">Mahasiswa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>NIM / NIP / Username Login *</label>
                    <input type="text" name="nim_nip" id="editNimNip" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" id="editEmail" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Status Akun</label>
                    <select name="status" id="editStatus" class="form-control">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
                <div id="editAdminFields">
                    <div class="form-group">
                        <label>Jabatan / Unit</label>
                        <input type="text" name="jabatan" id="editJabatan" class="form-control">
                    </div>
                </div>
                <div id="editSivitasFields" style="display:none;">
                    <div class="form-group">
                        <label>Fakultas</label>
                        <input type="text" name="fakultas" id="editFakultas" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <input type="text" name="program_studi" id="editProdi" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Nomor Handphone (Opsional)</label>
                    <input type="text" name="no_hp" id="editNoHp" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="btn-modal-submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function confirmDeleteUser(actionUrl, userName) {
        const modal = document.getElementById('modalDelete');
        const targetName = document.getElementById('deleteTargetUserName');
        const form = document.getElementById('formDeleteUser');
        if (targetName) targetName.textContent = userName || 'pengguna ini';
        if (form) form.action = actionUrl;
        if (modal) modal.classList.add('show');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    function openCreateModal() {
        document.getElementById('modalCreate').classList.add('show');
        toggleRoleFields('create');
    }

    function openPasswordModal(userId, name, nimNip) {
        const modal = document.getElementById('modalPassword');
        document.getElementById('pwModalUserName').textContent = name;
        document.getElementById('pwModalUserNip').textContent = nimNip || 'Tanpa NIM/NIP';
        document.getElementById('formUpdatePassword').action = `/superadmin/users/${userId}/password`;
        modal.classList.add('show');
    }

    function openEditModal(userId, nama, nimNip, email, role, status, jabatan, prodi, fakultas, noHp) {
        const modal = document.getElementById('modalEdit');
        document.getElementById('editNama').value = nama || '';
        document.getElementById('editNimNip').value = nimNip || '';
        document.getElementById('editEmail').value = (email && email !== '—') ? email : '';
        document.getElementById('editRole').value = role;
        document.getElementById('editStatus').value = status || 'aktif';
        document.getElementById('editJabatan').value = (jabatan && jabatan !== '—') ? jabatan : '';
        document.getElementById('editProdi').value = (prodi && prodi !== '—') ? prodi : '';
        document.getElementById('editFakultas').value = (fakultas && fakultas !== '—') ? fakultas : '';
        document.getElementById('editNoHp').value = (noHp && noHp !== '—') ? noHp : '';

        document.getElementById('formEditUser').action = `/superadmin/users/${userId}`;
        toggleRoleFields('edit');
        modal.classList.add('show');
    }

    function toggleRoleFields(prefix) {
        const role = document.getElementById(prefix + 'Role' + (prefix === 'create' ? 'Select' : '')).value;
        const adminFields = document.getElementById(prefix + 'AdminFields');
        const sivitasFields = document.getElementById(prefix + 'SivitasFields');

        if (role === 'admin' || role === 'super_admin') {
            adminFields.style.display = 'block';
            sivitasFields.style.display = 'none';
        } else {
            adminFields.style.display = 'none';
            sivitasFields.style.display = 'block';
        }
    }

    // Tutup modal jika klik di luar box
    document.querySelectorAll('.modal-backdrop').forEach((backdrop) => {
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) {
                backdrop.classList.remove('show');
            }
        });
    });
</script>
</body>
</html>
