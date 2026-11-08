<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa | SIPRESKA</title>
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
            --purple-mid: #8058B8;
            --gold: #C9A227;
            --text: #342847;
            --muted: #80758F;
            --border: #E7DFF0;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(circle at 90% 5%, rgba(197,165,233,.22), transparent 30%),
                linear-gradient(135deg, #FFFFFF 0%, #F8F5FC 48%, #EEE5F8 100%);
        }

        .layout { display: flex; min-height: 100vh; }

        /* SIDEBAR MAHASISWA */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            display: flex;
            flex-direction: column;
            width: 250px;
            height: 100vh;
            padding: 28px 20px;
            overflow-y: auto;
            background: rgba(255,255,255,.98);
            border-right: 1px solid var(--border);
            box-shadow: 5px 0 25px rgba(67,39,101,.035);
            z-index: 100;
        }

        .logo {
            display: block;
            padding: 0 10px;
            text-decoration: none;
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

        /* MAIN CONTENT */
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

        .role-tag-mhs {
            padding: 2.5px 8px;
            border-radius: 6px;
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #047857;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        /* WELCOME BANNER */
        .welcome {
            margin-bottom: 26px;
            padding: 26px 28px;
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
            max-width: 660px;
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
            line-height: 1.75;
        }

        .btn-welcome-action {
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
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(91,58,142,.22);
            transition: transform .15s ease, box-shadow .15s ease;
            white-space: nowrap;
        }

        .btn-welcome-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(91,58,142,.32);
            background: linear-gradient(135deg, #6C44A7 0%, #482A75 100%);
        }

        /* 4 STAT CARDS (SERAGAM DENGAN DASHBOARD ADMIN) */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        @media (max-width: 1100px) {
            .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: 1fr; }
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

        .stat-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            margin-bottom: 12px;
        }

        .stat-label {
            color: #6C5E7F;
            font-size: 13px;
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
        .stat-pill.pending { background: #FFF7E6; color: #9A6C05; border: 1px solid #FFE6A8; }
        .stat-pill.approved { background: #EDF9F1; color: #157A3C; border: 1px solid #C4ECCF; }
        .stat-pill.rejected { background: #FDF2F2; color: #B91C1C; border: 1px solid #FACDCD; }

        .stat-number {
            color: #2D1A47;
            font-size: 30px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
            overflow-wrap: anywhere;
        }

        .stat-number.pending { color: #B47805; }
        .stat-number.approved { color: #1E824C; }
        .stat-number.rejected { color: #B91C1C; }

        .stat-note {
            color: #8C7F9E;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.4;
        }

        /* SECTION TITLE */
        .section-title {
            margin: 0 0 16px;
            color: var(--purple-dark);
            font-size: 18px;
            font-weight: 800;
            font-family: 'Poppins', sans-serif;
        }

        /* QUICK ACTIONS */
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        @media (max-width: 900px) {
            .actions-grid { grid-template-columns: 1fr; }
        }

        .action-card {
            background: #FFFFFF;
            border: 1px solid #ECE4F4;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 4px 16px rgba(67, 39, 101, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(67, 39, 101, 0.08);
            border-color: #DCCFE8;
        }

        .action-icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #F4EFFB;
            border: 1px solid #E5D6F6;
            color: var(--purple);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .action-card h3 {
            margin: 0 0 8px;
            color: #2D1A47;
            font-size: 16px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
        }

        .action-card p {
            margin: 0 0 16px;
            color: #6C5E7F;
            font-size: 12.5px;
            line-height: 1.6;
        }

        .action-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--purple);
            font-size: 12.5px;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.15s ease;
        }

        .action-link:hover {
            transform: translateX(3px);
            color: var(--purple-dark);
        }

        /* RECENT ACHIEVEMENTS PANEL */
        .panel {
            padding: 26px 28px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: rgba(255,255,255,.98);
            box-shadow: 0 8px 28px rgba(67,39,101,.045);
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
        }

        .panel-title {
            margin: 0 0 4px;
            color: var(--purple-dark);
            font-size: 18px;
            font-weight: 800;
            font-family: 'Poppins', sans-serif;
        }

        .panel-subtitle {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
        }

        .panel-view-all {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--purple);
            font-size: 12.5px;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.15s ease;
        }

        .panel-view-all:hover {
            transform: translateX(3px);
        }

        .table-wrap {
            overflow-x: auto;
            border: 1px solid #ECE3F5;
            border-radius: 13px;
            background: #FFFFFF;
            box-shadow: 0 3px 12px rgba(67, 39, 101, 0.035);
        }

        .recent-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        .recent-table thead {
            background: #FAF8FD;
            border-bottom: 1px solid #ECE3F5;
        }

        .recent-table th {
            padding: 13px 18px;
            font-size: 11px;
            font-weight: 700;
            color: #6C5B82;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            white-space: nowrap;
        }

        .recent-table tbody tr {
            border-bottom: 1px solid #F3EDF8;
            transition: background 0.15s ease;
        }

        .recent-table tbody tr:last-child {
            border-bottom: none;
        }

        .recent-table tbody tr:hover {
            background: #FCFAFF;
        }

        .recent-table td {
            padding: 14px 18px;
            vertical-align: middle;
        }

        .prestasi-title-box strong {
            display: block;
            font-size: 13.5px;
            font-weight: 700;
            color: #2D1A47;
            line-height: 1.35;
            margin-bottom: 4px;
        }

        .prestasi-title-box small {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 4px;
            background: #F4EFFB;
            color: var(--purple);
            font-size: 10.5px;
            font-weight: 700;
        }

        .level-pill {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            border-radius: 6px;
            background: #F6F2FA;
            color: #55446C;
            font-size: 11px;
            font-weight: 600;
            border: 1px solid #E7DDF0;
        }

        .status-dot-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3.5px 9px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-dot-badge.disetujui {
            background: #EDF9F1;
            color: #157A3C;
            border: 1px solid #C4ECCF;
        }

        .status-dot-badge.menunggu_verifikasi {
            background: #FFF7E6;
            color: #9C6500;
            border: 1px solid #FFE7B3;
        }

        .status-dot-badge.ditolak {
            background: #FDF2F2;
            color: #B91C1C;
            border: 1px solid #FACDCD;
        }

        .status-dot-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .btn-table-action {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 7px;
            font-size: 11.5px;
            font-weight: 700;
            text-decoration: none;
            background: #FAF7FD;
            border: 1px solid #DFD2ED;
            color: var(--purple);
            transition: all 0.15s ease;
        }

        .btn-table-action:hover {
            background: #EDE4F8;
            border-color: var(--purple);
            color: var(--purple-dark);
            transform: translateY(-1px);
        }

        /* EMPTY STATE */
        .empty-box {
            padding: 40px 20px;
            text-align: center;
            color: var(--muted);
        }

        .empty-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #F4EFFB;
            color: var(--purple);
            margin-bottom: 12px;
        }

        .empty-box h4 {
            margin: 0 0 6px;
            color: #2D1A47;
            font-size: 15px;
            font-weight: 700;
        }

        .empty-box p {
            margin: 0 0 16px;
            font-size: 12.5px;
            line-height: 1.6;
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

        /* MODAL RINCIAN PRESTASI SAYA (IN-DASHBOARD) */
        .dash-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(36, 27, 49, 0.65);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .dash-modal-backdrop.active {
            display: flex;
            animation: dashFadeIn .2s ease-out;
        }

        @keyframes dashFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes dashPopIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .dash-modal-card {
            background: #FFFFFF;
            border-radius: 20px;
            width: 100%;
            max-width: 660px;
            max-height: 88vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(45, 27, 78, 0.35);
            animation: dashPopIn .22s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        .dash-modal-header {
            padding: 24px 28px 18px;
            border-bottom: 1px solid #ECE4F4;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            background: #FFFFFF;
        }

        .dash-modal-eyebrow {
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--purple-mid);
            margin-bottom: 4px;
        }

        .dash-modal-title {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: var(--text);
            line-height: 1.35;
        }

        .dash-modal-close {
            background: #F4EEFB;
            border: none;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--purple);
            cursor: pointer;
            transition: all .15s ease;
            flex-shrink: 0;
            margin-left: 14px;
        }

        .dash-modal-close:hover {
            background: #E8DDF7;
            transform: rotate(90deg);
        }

        .dash-modal-body {
            padding: 22px 28px;
            overflow-y: auto;
            flex: 1;
        }

        .dash-modal-note-box {
            background: #FFFBEB;
            border: 1px solid #FDE68A;
            border-left: 4px solid #D97706;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .dash-modal-note-header {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 11.5px;
            font-weight: 700;
            color: #92400E;
            margin-bottom: 4px;
        }

        .dash-modal-note-text {
            margin: 0;
            font-size: 13px;
            color: #78350F;
            line-height: 1.5;
        }

        .dash-modal-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px 16px;
            margin-bottom: 20px;
        }

        @media (max-width: 600px) {
            .dash-modal-grid {
                grid-template-columns: 1fr;
            }
        }

        .dash-info-item {
            background: #FAF7FD;
            border: 1px solid #EFE8F7;
            border-radius: 12px;
            padding: 12px 14px;
        }

        .dash-info-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: var(--muted);
            margin-bottom: 4px;
        }

        .dash-info-val {
            display: block;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.35;
        }

        .dash-info-block {
            margin-bottom: 18px;
        }

        .dash-team-list {
            background: #FAF7FD;
            border: 1px solid #EFE8F7;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 13px;
            color: var(--text);
            line-height: 1.5;
            white-space: pre-line;
        }

        .dash-desc-text {
            background: #FAF7FD;
            border: 1px solid #EFE8F7;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 13px;
            color: var(--text);
            line-height: 1.5;
            margin: 0;
            white-space: pre-line;
        }

        .dash-evidence-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .dash-evidence-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #FFFFFF;
            border: 1px solid #ECE4F4;
            border-radius: 10px;
            padding: 10px 14px;
            gap: 12px;
            transition: all .15s ease;
        }

        .dash-evidence-item:hover {
            border-color: var(--purple-mid);
            background: #FAF7FD;
        }

        .dash-evidence-left {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .dash-evidence-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #F4EEFB;
            color: var(--purple);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dash-evidence-title {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dash-evidence-type {
            font-size: 11px;
            color: var(--muted);
        }

        .btn-open-file {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--purple);
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 7px;
            background: #FAF7FD;
            border: 1px solid #DFD2ED;
            transition: all .15s ease;
            flex-shrink: 0;
        }

        .btn-open-file:hover {
            background: var(--purple);
            color: #FFFFFF;
            border-color: var(--purple);
        }

        .dash-modal-footer {
            padding: 16px 28px;
            border-top: 1px solid #ECE4F4;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            background: #FAF7FD;
        }

        .btn-dash-close {
            padding: 10px 20px;
            border-radius: 10px;
            border: 1px solid #DFD2ED;
            background: #FFFFFF;
            color: var(--text);
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s ease;
        }

        .btn-dash-close:hover {
            background: #F4EEFB;
            color: var(--purple);
        }

        .btn-dash-edit {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, var(--purple-mid), var(--purple));
            color: #FFFFFF;
            font-size: 12.5px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(128, 88, 184, 0.35);
            transition: all .15s ease;
        }

        .btn-dash-edit:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }
    </style>
</head>

<body>
<div class="layout">

    {{-- SIDEBAR MAHASISWA --}}
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SIPRESKA" width="34" height="36" style="display: block; margin-bottom: 8px; object-fit: contain;">
            SIPRESKA
            <small>Sistem Informasi Pendataan dan Pengelolaan Prestasi Sivitas</small>
        </a>

        <div class="gold-line"></div>
        <div class="menu-title">MENU MAHASISWA</div>

        <nav class="menu">
            {{-- DASHBOARD --}}
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </span>
                Dashboard
            </a>

            {{-- DAFTAR PRESTASI --}}
            <a href="{{ route('prestasi') }}" class="{{ request()->routeIs('prestasi') ? 'active' : '' }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </span>
                Daftar Prestasi
            </a>

            {{-- PENGAJUAN PRESTASI --}}
            <a href="{{ route('prestasi.create') }}" class="{{ request()->routeIs('prestasi.create') ? 'active' : '' }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                </span>
                Pengajuan Prestasi
            </a>

            {{-- PANDUAN PENGGUNAAN --}}
            <a href="{{ route('panduan') }}" class="{{ request()->routeIs('panduan') ? 'active' : '' }}">
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
                <div class="eyebrow">PORTAL SIVITAS MAHASISWA</div>
                <h1>Dashboard Mahasiswa</h1>
            </div>
            <div class="user-profile-badge">
                <span class="role-tag-mhs">MAHASISWA</span>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--purple); flex-shrink: 0;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span>{{ session('campus_display_name', auth()->user()->sivitas?->nama ?? 'Mahasiswa') }}</span>
            </div>
        </header>

        {{-- WELCOME CARD --}}
        <section class="welcome">
            <div class="welcome-content">
                <h2>Selamat datang, {{ session('campus_display_name', auth()->user()->sivitas?->nama ?? 'Mahasiswa Berprestasi') }}!</h2>
                <p>
                    Kelola rekam jejak capaian akademik maupun non-akademik Anda, lengkapi berkas bukti pendukung, dan pantau status persetujuan verifikasi secara terpusat.
                </p>
            </div>

            <a href="{{ route('prestasi.create') }}" class="btn-welcome-action">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Ajukan Prestasi Baru</span>
            </a>
        </section>

        {{-- 4 KARTU STATISTIK PRESTASI MAHASISWA --}}
        <section class="stats-grid">
            {{-- KARTU 1: TOTAL PRESTASI --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Total Prestasi Saya</span>
                    <span class="stat-pill purple">Portofolio</span>
                </div>
                <div class="stat-number">{{ number_format($totalPrestasiMahasiswa ?? 0, 0, ',', '.') }}</div>
                <div class="stat-note">Seluruh pengajuan tercatat</div>
            </article>

            {{-- KARTU 2: MENUNGGU VERIFIKASI --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Menunggu Verifikasi</span>
                    <span class="stat-pill pending">Dalam Proses</span>
                </div>
                <div class="stat-number pending">{{ number_format($pengajuanMenunggu ?? 0, 0, ',', '.') }}</div>
                <div class="stat-note">Menunggu telaah admin</div>
            </article>

            {{-- KARTU 3: DISETUJUI --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Prestasi Disetujui</span>
                    <span class="stat-pill approved">Terpublikasi</span>
                </div>
                <div class="stat-number approved">{{ number_format($prestasiDisetujui ?? 0, 0, ',', '.') }}</div>
                <div class="stat-note">Capaian resmi divalidasi</div>
            </article>

            {{-- KARTU 4: DITOLAK --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Prestasi Ditolak</span>
                    <span class="stat-pill rejected">Ditolak</span>
                </div>
                <div class="stat-number rejected">{{ number_format($prestasiDitolak ?? 0, 0, ',', '.') }}</div>
                <div class="stat-note">Tidak memenuhi syarat</div>
            </article>
        </section>

        {{-- AKSES CEPAT (QUICK ACTIONS) --}}
        <h2 class="section-title">Layanan Akses Cepat</h2>
        <section class="actions-grid">
            <article class="action-card">
                <div class="action-icon-circle">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                </div>
                <h3>Ajukan Prestasi Baru</h3>
                <p>Unggah berkas bukti sertifikat dan dokumentasi pencapaian kompetisi akademik maupun non-akademik terbaru Anda.</p>
                <a href="{{ route('prestasi.create') }}" class="action-link">
                    <span>Mulai Pengajuan</span>
                    <span aria-hidden="true">→</span>
                </a>
            </article>

            <article class="action-card">
                <div class="action-icon-circle">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </div>
                <h3>Jelajahi Arsip Prestasi</h3>
                <p>Cari data dan inspirasi prestasi sivitas akademika kampus dari berbagai tingkat dan kelompok kompetisi.</p>
                <a href="{{ route('prestasi') }}" class="action-link">
                    <span>Lihat Daftar Prestasi</span>
                    <span aria-hidden="true">→</span>
                </a>
            </article>

            <article class="action-card">
                <div class="action-icon-circle">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </div>
                <h3>Panduan & Ketentuan</h3>
                <p>Pelajari syarat pengunggahan berkas digital, ketentuan anggota tim beregu, dan alur telaah dari pihak verifikator.</p>
                <a href="{{ route('panduan') }}" class="action-link">
                    <span>Buka Panduan Lengkap</span>
                    <span aria-hidden="true">→</span>
                </a>
            </article>
        </section>

        {{-- PANEL PENGAJUAN TERBARU MAHASISWA --}}
        <section class="panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Pengajuan Prestasi Terbaru Saya</h2>
                    <p class="panel-subtitle">Daftar lima pengajuan prestasi terakhir yang terhubung dengan akun Anda.</p>
                </div>
                <a href="{{ route('prestasi') }}" class="panel-view-all">
                    <span>Lihat semua di portofolio</span>
                    <span aria-hidden="true">→</span>
                </a>
            </div>

            @if (isset($prestasiTerbaru) && $prestasiTerbaru->isNotEmpty())
                <div class="table-wrap">
                    <table class="recent-table">
                        <thead>
                            <tr>
                                <th>Nama Prestasi & Kategori</th>
                                <th>Tingkat</th>
                                <th>Tahun</th>
                                <th>Status Verifikasi</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                                                        @foreach ($prestasiTerbaru as $prestasi)
                                @php
                                    $statusLabel = match ($prestasi->status) {
                                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                        'disetujui' => 'Disetujui',
                                        'perlu_perbaikan' => 'Perlu Perbaikan',
                                        'ditolak' => 'Ditolak',
                                        default => 'Dalam Proses',
                                    };

                                    $statusClass = match ($prestasi->status) {
                                        'disetujui' => 'disetujui',
                                        'ditolak' => 'ditolak',
                                        'perlu_perbaikan' => 'perlu_perbaikan',
                                        default => 'menunggu_verifikasi',
                                    };

                                    $catatanVerifikasi = $prestasi->verifikasi?->sortByDesc('tanggal_verifikasi')->first()?->catatan;
                                    $anggotaStr = $prestasi->anggota->map(fn($a) => ($a->sivitas?->user?->name ?? $a->nama ?? $a->nim_nip) . ($a->peran === 'pengaju' ? ' (Ketua/Pengaju)' : ''))->join("\n");
                                    $buktiPayload = $prestasi->bukti->map(fn($b) => [
                                        'nama' => $b->nama_file ?: $b->jenis_bukti,
                                        'jenis' => $b->jenis_bukti,
                                        'url' => asset('storage/' . $b->path_file),
                                    ]);

                                    $modalData = [
                                        'nama' => $prestasi->nama_prestasi,
                                        'kategori' => $prestasi->kategori?->nama_kategori ?? 'Umum',
                                        'tingkat' => $prestasi->tingkat?->nama_tingkat ?? '—',
                                        'peringkat' => $prestasi->peringkat ?? '—',
                                        'tahun' => $prestasi->tahun ?? '—',
                                        'jenis' => ucfirst($prestasi->jenis_prestasi ?? 'individu'),
                                        'penyelenggara' => $prestasi->penyelenggara ?? '—',
                                        'deskripsi' => $prestasi->deskripsi ?? '—',
                                        'statusLabel' => $statusLabel,
                                        'statusClass' => $statusClass,
                                        'catatan' => $catatanVerifikasi,
                                        'anggota' => $anggotaStr,
                                        'bukti' => $buktiPayload,
                                        'editUrl' => in_array($prestasi->status, ['ditolak', 'perlu_perbaikan'], true) ? route('prestasi.edit', $prestasi) : null,
                                    ];
                                @endphp
                                <tr>
                                    <td>
                                        <div class="prestasi-title-box">
                                            <strong>{{ $prestasi->nama_prestasi }}</strong>
                                            <small>{{ $prestasi->kategori?->nama_kategori ?? 'Umum' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="level-pill">{{ $prestasi->tingkat?->nama_tingkat ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $prestasi->tahun ?: '—' }}</strong>
                                    </td>
                                    <td>
                                        <span class="status-dot-badge {{ $statusClass }}">
                                            <span class="dot"></span>
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <button type="button" class="btn-table-action" onclick='bukaModalRincian(@json($modalData))'>
                                            <span>Lihat Rincian</span>
                                            <span aria-hidden="true">→</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-box">
                    <div class="empty-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"></circle><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"></path></svg>
                    </div>
                    <h4>Belum Ada Prestasi yang Diajukan</h4>
                    <p>Anda belum memiliki rekam jejak prestasi yang diajukan. Mulai catat pencapaian membanggakan Anda sekarang!</p>
                    <a href="{{ route('prestasi.create') }}" class="btn-welcome-action">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Ajukan Prestasi Sekarang</span>
                    </a>
                </div>
            @endif
        </section>

    </main>
</div>
{{-- MODAL RINCIAN PRESTASI SAYA (IN-DASHBOARD, MODERN) --}}
<div class="dash-modal-backdrop" id="modalRincianPrestasi" aria-hidden="true" style="display:none;">
    <div class="dash-modal-card" role="dialog" aria-modal="true" aria-labelledby="rincianJudul">
        <header class="dash-modal-header">
            <div>
                <div class="dash-modal-eyebrow">RINCIAN PENGAJUAN PRESTASI SAYA</div>
                <h3 class="dash-modal-title" id="rincianJudul">—</h3>
                <div style="margin-top: 8px;">
                    <span id="rincianStatusBadge" class="status-dot-badge">
                        <span class="dot"></span>
                        <span id="rincianStatusLabel">—</span>
                    </span>
                </div>
            </div>
            <button type="button" class="dash-modal-close" onclick="tutupModalRincian()" aria-label="Tutup Rincian">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </header>

        <div class="dash-modal-body">
            {{-- Catatan Verifikator jika ada --}}
            <div id="rincianCatatanBox" class="dash-modal-note-box" style="display:none;">
                <div class="dash-modal-note-header">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <span>Catatan Tim Verifikator</span>
                </div>
                <p id="rincianCatatanText" class="dash-modal-note-text"></p>
            </div>

            {{-- Grid Info --}}
            <div class="dash-modal-grid">
                <div class="dash-info-item">
                    <span class="dash-info-label">Kategori Bidang</span>
                    <strong class="dash-info-val" id="rincianKategori">—</strong>
                </div>
                <div class="dash-info-item">
                    <span class="dash-info-label">Tingkat Kompetisi</span>
                    <strong class="dash-info-val" id="rincianTingkat">—</strong>
                </div>
                <div class="dash-info-item">
                    <span class="dash-info-label">Peringkat / Capaian</span>
                    <strong class="dash-info-val" id="rincianPeringkat">—</strong>
                </div>
                <div class="dash-info-item">
                    <span class="dash-info-label">Tahun Perolehan</span>
                    <strong class="dash-info-val" id="rincianTahun">—</strong>
                </div>
                <div class="dash-info-item">
                    <span class="dash-info-label">Bentuk Partisipasi</span>
                    <strong class="dash-info-val" id="rincianJenis">—</strong>
                </div>
                <div class="dash-info-item">
                    <span class="dash-info-label">Penyelenggara Kegiatan</span>
                    <strong class="dash-info-val" id="rincianPenyelenggara">—</strong>
                </div>
            </div>

            {{-- Anggota Tim jika kelompok --}}
            <div id="rincianTimBox" class="dash-info-block" style="display:none;">
                <span class="dash-info-label">Anggota Tim / Sivitas Terdaftar</span>
                <div id="rincianTimList" class="dash-team-list"></div>
            </div>

            {{-- Deskripsi --}}
            <div id="rincianDescBox" class="dash-info-block" style="display:none;">
                <span class="dash-info-label">Deskripsi Kegiatan</span>
                <p id="rincianDescText" class="dash-desc-text"></p>
            </div>

            {{-- Dokumen Bukti --}}
            <div class="dash-info-block">
                <span class="dash-info-label">Dokumen & Berkas Bukti Lampiran</span>
                <ul id="rincianBuktiList" class="dash-evidence-list"></ul>
            </div>
        </div>

        <footer class="dash-modal-footer">
            <div id="rincianActionWrapper" style="display:none;">
                <a id="rincianBtnEdit" href="#" class="btn-dash-edit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path><path d="m15 5 4 4"></path></svg>
                    <span>Perbaiki & Ajukan Kembali</span>
                </a>
            </div>
            <button type="button" class="btn-dash-close" onclick="tutupModalRincian()">Tutup</button>
        </footer>
    </div>
</div>

<script>
    const rincianModal = document.getElementById('modalRincianPrestasi');
    const rincianJudul = document.getElementById('rincianJudul');
    const rincianStatusBadge = document.getElementById('rincianStatusBadge');
    const rincianStatusLabel = document.getElementById('rincianStatusLabel');
    const rincianCatatanBox = document.getElementById('rincianCatatanBox');
    const rincianCatatanText = document.getElementById('rincianCatatanText');
    const rincianKategori = document.getElementById('rincianKategori');
    const rincianTingkat = document.getElementById('rincianTingkat');
    const rincianPeringkat = document.getElementById('rincianPeringkat');
    const rincianTahun = document.getElementById('rincianTahun');
    const rincianJenis = document.getElementById('rincianJenis');
    const rincianPenyelenggara = document.getElementById('rincianPenyelenggara');
    const rincianTimBox = document.getElementById('rincianTimBox');
    const rincianTimList = document.getElementById('rincianTimList');
    const rincianDescBox = document.getElementById('rincianDescBox');
    const rincianDescText = document.getElementById('rincianDescText');
    const rincianBuktiList = document.getElementById('rincianBuktiList');
    const rincianActionWrapper = document.getElementById('rincianActionWrapper');
    const rincianBtnEdit = document.getElementById('rincianBtnEdit');

    function bukaModalRincian(data) {
        if (!rincianModal) return;

        rincianJudul.textContent = data.nama || '—';
        rincianStatusLabel.textContent = data.statusLabel || '—';
        rincianStatusBadge.className = 'status-dot-badge ' + (data.statusClass || 'menunggu_verifikasi');

        // Catatan
        if (data.catatan && data.catatan.trim() !== '') {
            rincianCatatanText.textContent = data.catatan;
            rincianCatatanBox.style.display = 'block';
        } else {
            rincianCatatanBox.style.display = 'none';
        }

        // Info
        rincianKategori.textContent = data.kategori || '—';
        rincianTingkat.textContent = data.tingkat || '—';
        rincianPeringkat.textContent = data.peringkat || '—';
        rincianTahun.textContent = data.tahun || '—';
        rincianJenis.textContent = data.jenis || '—';
        rincianPenyelenggara.textContent = data.penyelenggara || '—';

        // Tim
        if (data.anggota && data.anggota.trim() !== '') {
            rincianTimList.textContent = data.anggota;
            rincianTimBox.style.display = 'block';
        } else {
            rincianTimBox.style.display = 'none';
        }

        // Deskripsi
        if (data.deskripsi && data.deskripsi.trim() !== '') {
            rincianDescText.textContent = data.deskripsi;
            rincianDescBox.style.display = 'block';
        } else {
            rincianDescBox.style.display = 'none';
        }

        // Bukti
        rincianBuktiList.innerHTML = '';
        if (Array.isArray(data.bukti) && data.bukti.length > 0) {
            data.bukti.forEach(b => {
                const li = document.createElement('li');
                li.className = 'dash-evidence-item';
                li.innerHTML = `
                    <div class="dash-evidence-left">
                        <div class="dash-evidence-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                        <div>
                            <div class="dash-evidence-title">${escapeHtml(b.nama)}</div>
                            <div class="dash-evidence-type">Berkas Bukti (${escapeHtml(b.jenis)})</div>
                        </div>
                    </div>
                    <a href="${b.url}" target="_blank" rel="noopener noreferrer" class="btn-open-file">
                        <span>Buka Berkas</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </a>
                `;
                rincianBuktiList.appendChild(li);
            });
        } else {
            const li = document.createElement('li');
            li.style.color = '#80758F';
            li.style.fontSize = '12px';
            li.style.padding = '8px 0';
            li.textContent = 'Tidak ada berkas bukti lampiran yang terunggah.';
            rincianBuktiList.appendChild(li);
        }

        // Action Edit
        if (data.editUrl) {
            rincianBtnEdit.href = data.editUrl;
            rincianActionWrapper.style.display = 'block';
        } else {
            rincianActionWrapper.style.display = 'none';
        }

        rincianModal.style.display = 'flex';
        void rincianModal.offsetWidth;
        rincianModal.classList.add('active');
        rincianModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalRincian() {
        if (!rincianModal) return;
        rincianModal.classList.remove('active');
        rincianModal.style.display = 'none';
        rincianModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    if (rincianModal) {
        rincianModal.addEventListener('click', (e) => {
            if (e.target === rincianModal) tutupModalRincian();
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && rincianModal && rincianModal.classList.contains('active')) {
            tutupModalRincian();
        }
    });

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
</script>
</body>
</html>
